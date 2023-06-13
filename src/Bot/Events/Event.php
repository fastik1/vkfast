<?php


namespace Fastik1\Vkfast\Bot\Events;


use Fastik1\Vkfast\Api\VkApi;
use stdClass;

class Event
{
    public VkApi $api;

    public function __construct(VkApi $api)
    {
        $this->api = $api;
    }
}