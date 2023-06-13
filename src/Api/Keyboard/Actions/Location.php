<?php

namespace Fastik1\Vkfast\Api\Keyboard\Actions;

class Location extends Action
{
    protected string $type = 'location';
    protected string|array $payload;

    public function __construct(string|array $payload = '')
    {
        $this->payload = $payload;
    }
}