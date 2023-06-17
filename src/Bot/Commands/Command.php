<?php

namespace Fastik1\Vkfast\Bot\Commands;

abstract class Command
{
    abstract public function validate(object $event, string $command, array $arguments): bool|array;

    public static function _validateCommand(array $commands, string $prefix, string $text): bool|array
    {
        if (!str_starts_with($text, $prefix)) {
            return false;
        }

        foreach ($commands as $command) {
            if (explode(' ', substr($text, strlen($prefix)))[0] == $command) {
                return ['command' => $command, 'arguments' => explode(' ', substr($text, strlen($prefix . $command) + 1))];
            }
        }

        return false;
    }
}