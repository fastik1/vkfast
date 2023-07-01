<?php


namespace Fastik1\Vkfast\Bot\Rules;


use Fastik1\Vkfast\Bot\Events\Event;

abstract class BaseRule
{
    abstract public function passes(Event $event): bool;

    public static function _validateRules(object $event, array $rules): bool
    {
        foreach ($rules as $rule) {
            if (!$rule->passes($event)) {
                return false;
            }
        }

        return true;
    }
}