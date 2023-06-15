<?php


namespace Fastik1\Vkfast\Bot\Events;


use Fastik1\Vkfast\Api\VkApi;
use Fastik1\Vkfast\Utils;

class Event
{
    public VkApi $api;
    public string $type;
    public object $raw;

    public function __construct(VkApi $api)
    {
        $this->api = $api;
        $this->type = Utils::classNameToEvent(static::class);
    }

    public function __toString(): string
    {
        return $this->type;
    }

}