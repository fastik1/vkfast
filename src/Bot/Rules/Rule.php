<?php


namespace Fastik1\Vkfast\Bot\Rules;


class Rule
{
    public static function validateRules(array $rules, object $event): bool
    {
        foreach ($rules as $rule) {
            if (!$rule->passes($event)) {
                return false;
            }
        }

        return true;
    }
}