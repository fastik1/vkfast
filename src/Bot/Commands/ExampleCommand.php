<?php

namespace Fastik1\Vkfast\Bot\Commands;

use Fastik1\Vkfast\Interfaces\CommandInterface;
use stdClass;

class ExampleCommand implements CommandInterface
{
    public function validate(stdClass $event, string $command, array $arguments): bool|array
    {
        return ['command' => $command, 'arguments' => $arguments];
    }
}