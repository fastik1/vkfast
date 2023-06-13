<?php

namespace Fastik1\Vkfast\Api\Keyboard\Actions;

class Action
{

    public function getData(): array
    {
        $data = [];
        $vars = get_object_vars($this);

        foreach ($vars as $name => $value) {
            $data[$name] = $value;
        }

        return $data;
    }
}