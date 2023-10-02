<?php

namespace Fastik1\Vkfast\Bot\Configuration;

use Closure;

class ActionConfiguration extends Configuration
{
    public ?string $class = null;
    public ?string $method = null;
    public ?Closure $callback = null;

    public function __construct(?string $class = null, ?string $method = null, ?Closure $callback = null)
    {
        $this->class = $class;
        $this->method = $method;
        $this->callback = $callback;
    }
}