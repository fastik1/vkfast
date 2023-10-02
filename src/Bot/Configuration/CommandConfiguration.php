<?php

namespace Fastik1\Vkfast\Bot\Configuration;

use Fastik1\Vkfast\Bot\Commands\BaseCommand;

class CommandConfiguration extends Configuration
{
    public string|array $name;
    public string $path;
    public ?BaseCommand $class = null;

    public function __construct(array|string $name, string $path, ?BaseCommand $class = null)
    {
        $this->name = $name;
        $this->path = $path;
        $this->class = $class;
    }
}