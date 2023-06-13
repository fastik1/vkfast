<?php

namespace Fastik1\Vkfast\Api\Keyboard\Actions;

class OpenLink extends Action
{
    protected string $type = 'open_link';
    protected string $label;
    protected string $link;
    protected string|array $payload;

    public function __construct(string $label, string $link, string|array $payload = '')
    {
        $this->label = $label;
        $this->link = $link;
        $this->payload = $payload;
    }
}