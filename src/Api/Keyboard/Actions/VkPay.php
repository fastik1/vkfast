<?php

namespace Fastik1\Vkfast\Api\Keyboard\Actions;

class VkPay extends Action
{
    protected string $type = 'vkpay';
    protected string $hash;
    protected string|array $payload;

    public function __construct(string $hash, string|array $payload = '')
    {
        $this->hash = $hash;
        $this->payload = $payload;
    }
}