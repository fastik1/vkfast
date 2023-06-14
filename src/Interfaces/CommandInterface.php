<?php

namespace Fastik1\Vkfast\Interfaces;


interface CommandInterface
{
    public function validate(object $event, string $command, array $arguments): bool|array;
}