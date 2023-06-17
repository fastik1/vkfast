<?php

namespace Fastik1\Vkfast\Bot\Commands;

class ExampleCommand extends Command
{
    public function validate(object $event, string $command, array $arguments): bool|array
    {
        return ['command' => $command, 'arguments' => $arguments];
    }
}