<?php


namespace Fastik1\Vkfast\Bot\Events;


use Fastik1\Vkfast\Api\Entities\Forward;
use Fastik1\Vkfast\Api\Keyboard\Keyboard;

/**
 * @property \Fastik1\Vkfast\Bot\Events\Objects\Message $message
 * @property \Fastik1\Vkfast\Bot\Events\Objects\ClientInfo $client_info
 */
class MessageNew extends Event
{
    public function answer(string|int $message, ?Keyboard $keyboard = null, ?Forward $forward = null, bool $mentions = false, ?string $attachment = null, ?bool $is_reply = false, ...$arguments): mixed
    {
        if ($is_reply) {
            $forward = new Forward($this->message->peer_id, true);

            if ($this->message->from_id == $this->message->peer_id) {
                $forward->addMessageId($this->message->id);
            } else {
                $forward->addConversationMessageId($this->message->conversation_message_id);
            }
        }

        return $this->api->sendMessage($this->message->peer_id, $message, $keyboard, $forward, $mentions, $attachment, ...$arguments);
    }

    public function reply(string|int $message, ?Keyboard $keyboard = null, ?Forward $forward = null, bool $mentions = false, ?string $attachment = null, ...$arguments): mixed
    {
        return $this->answer($message, $keyboard, $forward, $mentions, $attachment, true, ...$arguments);
    }
}