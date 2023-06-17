<?php


namespace Fastik1\Vkfast\Bot\Rules;


abstract class Rule
{
    abstract public function passes($event): bool;

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