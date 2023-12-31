<?php

namespace Fastik1\Vkfast\Bot;

use Closure;
use Exception;
use Fastik1\Vkfast\Api\VkApi;
use Fastik1\Vkfast\Bot\Commands\BaseCommand;
use Fastik1\Vkfast\Bot\Configuration\HandlerConfiguration;
use Fastik1\Vkfast\Bot\Events\Event;
use Fastik1\Vkfast\Bot\Events\MessageNew;
use Fastik1\Vkfast\Bot\Rules\BaseRule;
use Fastik1\Vkfast\Exceptions\VkApiError;
use Fastik1\Vkfast\Exceptions\VkBotException;
use Fastik1\Vkfast\Bot\Rules\IsChatMessageBaseRule;
use Fastik1\Vkfast\Bot\Rules\IsPrivateMessageBaseRule;
use Fastik1\Vkfast\Traits\AttrubuteHandlers;
use Fastik1\Vkfast\Utils;

class VkBot
{
    use AttrubuteHandlers;

    public VkApi $api;
    private array $handlers = [];
    private string $secret = '';
    private string $prefix = '!';

    public function __construct(VkApi $api)
    {
        $this->api = $api;
    }

    public function on(string $eventType, Closure|Array $action): HandlerConfiguration
    {
        $handlerConfiguration = new HandlerConfiguration($eventType, $action);
        $attrubuteHandlersName = Utils::eventTypeToAttributeName(Utils::classNameToEvent($eventType));
        $this->$attrubuteHandlersName[] = $handlerConfiguration;
        return $handlerConfiguration;
    }

    public function message(Closure|Array $action): HandlerConfiguration
    {
        return $this->on(MessageNew::class, $action);
    }

    public function privateMessage(Closure|Array $action): HandlerConfiguration
    {
        return $this->on(MessageNew::class, $action)->rule(new IsPrivateMessageBaseRule());
    }

    public function chatMessage(Closure|Array $action): HandlerConfiguration
    {
        return $this->on(MessageNew::class, $action)->rule(new IsChatMessageBaseRule());
    }

    public function run(array|object|null $rawEvent = null): void
    {
        if (is_array($rawEvent)) {
            $rawEvent = json_decode(json_encode($rawEvent));
        }

        if (!$rawEvent) {
            $rawEvent = $this->getEvent();
        }

        if (!$rawEvent) {
            return;
        }

        $classEvent = '\\Fastik1\\Vkfast\\Bot\\Events\\' . Utils::eventTypeToClassName($rawEvent->type);

        if (!class_exists($classEvent)) {
            $classEvent = Event::class;
        }

        $event = $this->fillEvent(new $classEvent($this->api), $rawEvent);

        $this->processHandlers($event, $rawEvent);
    }

    private function fillEvent(Event $event, object $rawEvent): Event
    {
        $event->raw = $rawEvent;

        foreach ($event->raw->object ?? $event->raw as $key => $value) {
            $event->{$key} = $value;
        }

        return $event;
    }

    private function processHandlers(Event $event, object $rawEvent): void
    {
        $isNotContinueProcessingHandlerFound = false;
        $attrubuteHandlersName = Utils::eventTypeToAttributeName($event->type);

        foreach ($this->$attrubuteHandlersName as $handler) {
            if ($isNotContinueProcessingHandlerFound === true) {
                if (!$handler->continueProcessing) {
                    continue;
                }
            }

            if (Utils::classNameToEvent($handler->eventType) !== $rawEvent->type) {
                continue;
            }

            if (!BaseRule::_validateRules($event, $handler->rules ?? [])) {
                continue;
            }

            if ($handler->command) {
                $commandText = preg_replace('/\s+/', ' ', trim(Utils::getArrayElementByString($rawEvent, $handler->command->path)));
                $commandData = BaseCommand::_validateCommand([$handler->command->name], $this->prefix, $commandText);

                if (!$commandData) {
                    continue;
                }

                if ($handler->command->class) {
                    $commandData = $handler->command->class->validate($event, $commandData['command'], $commandData['arguments']);
                    if (!$commandData) {
                        continue;
                    }
                }

                $callbackParameters = [$event, $commandData['command'], ...$commandData['arguments']];
            } else {
                $callbackParameters = [$event];
            }

            if (!$handler->continueProcessing) {
                $isNotContinueProcessingHandlerFound = true;
            }

            $callback = $this->runHandler($handler, $callbackParameters);

            if (!is_null($callback)) {
                $this->response((string) $callback);
                return;
            }

        }

        $this->ok();
    }

    private function runHandler(HandlerConfiguration $handler, array $callbackParameters): mixed
    {
        try {
            if ($handler->action->callback) {
                $callback = ($handler->action->callback)(...$callbackParameters);
            } else {
                $classHandler = new $handler->action->class;
                $methodHandler = $handler->action->method;
                $callback = $classHandler->$methodHandler(...$callbackParameters);
            }
        } catch (VkApiError $exception) {
            throw new VkApiError($exception->getMessage(), $exception->getCode(), $exception);
        } catch (Exception $exception) {
            throw new VkBotException('Invalid callback function: ' . $exception->getMessage(), $exception->getCode(), $exception);
        }

        return $callback;
    }

    private function ok(): void
    {
        $this->response('ok');
    }

    private function response(int|string $response): void
    {
        echo $response;
    }

    private function validateEvent($event): bool
    {
        if (!isset($event->type)) {
            return false;
        }

        if ($this->secret and isset($event->secret)) {
            return $this->secret === $event->secret;
        }

        return true;
    }

    public function setSecret(string $secret = ''): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function setPrefix(string $prefix = ''): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    private function getEvent(): object|null
    {
        $event = json_decode(file_get_contents('php://input'));

        if ($this->validateEvent($event)) {
            return $event;
        }

        return null;
    }

    public function getHandlers(): array
    {
        return $this->handlers;
    }

}