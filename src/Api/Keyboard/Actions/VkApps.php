<?php

namespace Fastik1\Vkfast\Api\Keyboard\Actions;

class VkApps extends Action
{
    protected string $type = 'open_app';
    protected int $app_id;
    protected int $owner_id;
    protected string $label;
    protected string $hash;
    protected string|array $payload;

    public function __construct(int $app_id, int $owner_id, string $label = '', string $hash = '', string|array $payload = '')
    {
        $this->app_id = $app_id;
        $this->owner_id = $owner_id;
        $this->label = $label;
        $this->hash = $hash;
        $this->payload = $payload;
    }
}