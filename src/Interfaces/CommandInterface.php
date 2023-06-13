<?php

namespace Fastik1\Vkfast\Interfaces;

use stdClass;

interface CommandInterface
{
    public function validate(stdClass $event, string $command, array $arguments): bool|array;
}