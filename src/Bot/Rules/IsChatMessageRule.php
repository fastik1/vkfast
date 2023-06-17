<?php


namespace Fastik1\Vkfast\Bot\Rules;


use Fastik1\Vkfast\Interfaces\RuleInterface;

class IsChatMessageRule implements RuleInterface
{
    public function passes($event): bool
    {
        return $event->object->message->peer_id != $event->object->message->from_id;
    }
}