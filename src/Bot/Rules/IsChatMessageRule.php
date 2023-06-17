<?php

namespace Fastik1\Vkfast\Bot\Rules;

class IsChatMessageRule extends Rule
{
    public function passes($event): bool
    {
        return $event->object->message->peer_id != $event->object->message->from_id;
    }
}