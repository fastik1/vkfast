<?php


namespace Fastik1\Vkfast;


use stdClass;

class Utils
{
    public static function getArrayElementByString(stdClass $data, array|string|int $keys): mixed
    {
        if (is_string($keys)) $keys = explode('.', $keys);

        return array_reduce($keys, function($data, $key) {
            return isset($data->$key) ? $data->$key : null;
        }, $data);
    }

    public static function classNameToMethod($class): string
    {
        $array = explode('\\', $class);
        return lcfirst(end($array));
    }
}