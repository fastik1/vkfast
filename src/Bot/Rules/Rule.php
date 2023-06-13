<?php


namespace Fastik1\Vkfast\Bot\Rules;

use stdClass;

class Rule
{
    public static function validateRules(array $rules, stdClass $event): bool
    {
        foreach ($rules as $rule) {
            if (!$rule->passes($event)) {
                return false;
            }
        }

        return true;
    }
}