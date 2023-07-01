<?php

namespace Fastik1\Vkfast\Bot\Rules;

use Fastik1\Vkfast\Bot\Events\Event;
use Fastik1\Vkfast\Bot\Events\MessageNew;

class IsChatMessageBaseRule extends BaseRule
{
    public function passes(MessageNew|Event $event): bool
    {
        return $event->message->peer_id != $event->message->from_id;
    }
}