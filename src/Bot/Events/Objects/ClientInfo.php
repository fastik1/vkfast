<?php


namespace Fastik1\Vkfast\Bot\Events\Objects;


class ClientInfo extends Object
{
    public array|object|null $button_actions;
    public ?bool $carousel;
    public ?bool $inline_keyboard;
    public ?bool $keyboard;
    public ?int $lang_id;
}