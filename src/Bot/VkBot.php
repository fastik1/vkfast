<?php

namespace Fastik1\Vkfast\Bot;

use Fastik1\Vkfast\Api\VkApi;
use Fastik1\Vkfast\Bot\Commands\Command;
use Fastik1\Vkfast\Bot\Events\GroupEvent;
use Fastik1\Vkfast\Bot\Events\Event;
use Fastik1\Vkfast\Interfaces\CommandInterface;
use Fastik1\Vkfast\Bot\Rules\isChatMessageRule;
use Fastik1\Vkfast\Bot\Rules\isPrivateMessageRule;
use Fastik1\Vkfast\Bot\Rules\Rule;
use Fastik1\Vkfast\Utils;

class VkBot
{
    public VkApi $api;
    private array $handlers = [];
    private string $secret = '';
    private string $prefix = '!';

    public function __construct(VkApi $api)
    {
        $this->api = $api;
    }

    public function on(string $event, $callback_function): self
    {
        array_push($this->handlers, ['event' => $event, 'callback_function' => $callback_function]);
        return $this;
    }

    public function message($callback_function): self
    {
        $this->on(GroupEvent::MESSAGE_NEW, $callback_function);
        return $this;
    }

    public function privateMessage($callback_function): self
    {
        $this->on(GroupEvent::MESSAGE_NEW, $callback_function)->rules(new isPrivateMessageRule());
        return $this;
    }

    public function chatMessage($callback_function): self
    {
        $this->on(GroupEvent::MESSAGE_NEW, $callback_function)->rules(new isChatMessageRule());
        return $this;
    }

    public function rules(Rule|array $rules): self
    {
        if (is_array($rules)) {
            foreach ($rules as $rule) {
                $this->handlers[array_key_last($this->handlers)]['rules'][] = $rule;
            }
        } else {
            $this->handlers[array_key_last($this->handlers)]['rules'][] = $rules;
        }

        return $this;
    }

    public function command(string|array $commands, string $path = 'object.message.text', CommandInterface|null $classCommand = null): self
    {
        if (is_array($commands)) {
            $this->handlers[array_key_last($this->handlers)]['command'] = ['signatures' => $commands, 'path' => $path, 'class' => $classCommand];
        } else {
            $this->handlers[array_key_last($this->handlers)]['command'] = ['signatures' => [$commands], 'path' => $path, 'class' => $classCommand];
        }

        return $this;
    }

    public function continueProcessing(): self
    {
        $this->handlers[array_key_last($this->handlers)]['continue_processing'] = true;
        return $this;
    }

    public function run(): void
    {
        $rawEvent = $this->getEvent();

        if (!$rawEvent) {
            return;
        }

        $classEvent = '\\Fastik1\\Vkfast\\Bot\\Events\\' . Utils::eventTypeToClassName($rawEvent->type);

        if (!class_exists($classEvent)) {
            $classEvent = Event::class;
        }

        $event = new $classEvent($this->api);

        foreach ($rawEvent->object ?? $rawEvent as $key => $value) {
            $event->{$key} = $value;
        }

        foreach ($this->handlers as $data) {
            if ($data['event'] !== $rawEvent->type) {
                continue;
            }

            if (!Rule::validateRules($data['rules'] ?? [], $rawEvent)) {
                continue;
            }

            if (!empty($data['command'])) {
                $commandText = Utils::getArrayElementByString($rawEvent, $data['command']['path']);
                $commandData = Command::validate($data['command']['signatures'], $this->prefix, $commandText);

                if (!$commandData) {
                    continue;
                }

                if ($data['command']['class']) {
                    $commandData = $data['command']['class']->validate($rawEvent, $commandData['command'], $commandData['arguments']);
                    if (!$commandData) {
                        continue;
                    }
                }

                $callback = $data['callback_function']($event, $commandData['command'], ...$commandData['arguments']);
            } else {
                $callback = $data['callback_function']($event);
            }

            if ($callback) {
                $this->response((string) $callback);
                break;
            }

            if (!isset($data['continue_processing']) or !$data['continue_processing']) {
                break;
            }
        }

        $this->ok();
    }

    private function ok(): void
    {
        echo 'ok';
    }

    private function response(int|string $response): void
    {
        die($response);
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