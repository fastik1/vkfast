<?php

namespace Fastik1\Vkfast\Bot\Commands;

class ExampleBaseCommand extends BaseCommand
{
    public function validate(object $event, string $command, array $arguments): bool|array
    {
        return ['command' => $command, 'arguments' => $arguments];
    }
}