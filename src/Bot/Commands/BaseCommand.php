<?php

namespace Fastik1\Vkfast\Bot\Commands;

use Fastik1\Vkfast\Bot\Events\Event;

abstract class BaseCommand
{
    abstract public function validate(Event $event, string $command, array $arguments): bool|array;

    public static function _validateCommand(array $commands, string $prefix, string $text): bool|array
    {
        if (!str_starts_with($text, $prefix)) {
            return false;
        }

        foreach ($commands as $command) {
            if (explode(' ', trim(substr($text, strlen($prefix))))[0] == $command) {
                return ['command' => $command, 'arguments' => array_diff(explode(' ', trim(substr($text, strlen($prefix . $command) + 1))), array(''))];
            }
        }

        return false;
    }
}