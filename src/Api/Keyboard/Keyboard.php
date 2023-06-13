<?php

namespace Fastik1\Vkfast\Api\Keyboard;

use Fastik1\Vkfast\Api\Keyboard\Actions\Action;

class Keyboard
{
    private bool $one_time;
    private bool $inline;
    private array $buttons = [];

    public function __construct(bool $one_time = false, bool $inline = false)
    {
        $this->one_time = $one_time;
        $this->inline = $inline;
    }

    public function add(Action $action, ?string $color = null): self
    {
        $this->buttons[] = [
            'action' => $action->getData(),
            'color' => $color,
        ];
        return $this;
    }

    public function row(): self
    {
        $this->buttons[] = [];
        return $this;
    }

    public function remove(): self
    {
        $this->buttons = [];
        return $this;
    }

    public function json(): string {
        $buttons = [];

        foreach ($this->buttons as $button) {
            if (!empty($button)) {
                $buttons[array_key_last($buttons) ?? 0][] = $button;
            } else {
                $buttons[] = [];
            }
        }

        $keyboard = $buttons ? [
            'one_time' => $this->one_time,
            'inline' => $this->inline,
            'buttons' => $buttons
        ] : [];

        return json_encode($keyboard, JSON_UNESCAPED_UNICODE);
    }
}