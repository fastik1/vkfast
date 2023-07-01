<?php


namespace Fastik1\Vkfast\Bot\Events;


use Fastik1\Vkfast\Api\Keyboard\Keyboard;

/**
 * @property \Fastik1\Vkfast\Bot\Events\Objects\Message $message
 * @property \Fastik1\Vkfast\Bot\Events\Objects\ClientInfo $client_info
 */
class MessageNew extends Event
{
    public function answer(int|string $message, ?Keyboard $keyboard = null, ?string $attachment = null, ...$arguments): mixed
    {
        return $this->api->sendMessage($this->message->peer_id, $message, $keyboard, $attachment, $arguments);
    }
}