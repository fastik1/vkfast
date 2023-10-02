<?php

namespace Fastik1\Vkfast\Bot\Configuration;

use Closure;
use Fastik1\Vkfast\Bot\Commands\BaseCommand;
use Fastik1\Vkfast\Bot\Rules\BaseRule;

class HandlerConfiguration extends Configuration
{
    public string $eventType;
    public ActionConfiguration $action;
    public array $rules = [];
    public ?CommandConfiguration $command = null;
    public bool $continueProcessing = false;

    public function __construct(string $eventType, Closure|array $action)
    {
        $this->eventType = $eventType;
        $this->action = is_callable($action) ? new ActionConfiguration(callback: $action) : new ActionConfiguration($action[0], $action[1]);
    }

    public function rule(BaseRule|array $rule): self
    {
        if (is_array($rule)) {
            foreach ($rule as $items) {
                $this->rules[] = $items;
            }
        } else {
            $this->rules[] = $rule;
        }

        return $this;
    }

    public function command(string|array $commands, string $path = 'object.message.text', BaseCommand|null $classCommand = null): self
    {
        $this->command = new CommandConfiguration($commands, $path, $classCommand);
        return $this;
    }

    public function continueProcessing(): self
    {
        $this->continueProcessing = true;
        return $this;
    }
}