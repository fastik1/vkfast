<?php

namespace Fastik1\Vkfast\Bot\Commands;

use Fastik1\Vkfast\Interfaces\CommandInterface;

class ExampleCommand implements CommandInterface
{
    public function validate(object $event, string $command, array $arguments): bool|array
    {
        return ['command' => $command, 'arguments' => $arguments];
    }
}