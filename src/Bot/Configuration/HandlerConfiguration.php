<?php

namespace Fastik1\Vkfast\Bot\Configuration;

use Closure;

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
}