<?php

namespace Fastik1\Vkfast\Api\Keyboard\Actions;

class Callback extends Action
{
    protected string $type = 'callback';
    protected string $label;
    protected string|array $payload;

    public function __construct(string $label, string|array $payload = '')
    {
        $this->label = $label;
        $this->payload = $payload;
    }
}