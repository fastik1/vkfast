<?php


namespace Fastik1\Vkfast;


class Utils
{
    public static function getArrayElementByString(object $data, array|string|int $keys): mixed
    {
        if (is_string($keys)) $keys = explode('.', $keys);

        return array_reduce($keys, function($data, $key) {
            return isset($data->$key) ? $data->$key : null;
        }, $data);
    }

    public static function classNameToMethod(string $class): string
    {
        $array = explode('\\', $class);
        return lcfirst(end($array));
    }

    public static function eventTypeToClassName(string $eventType): string
    {
        $words = explode('_', $eventType);
        foreach ($words as $key => $value) {
            $words[$key] = ucfirst($value);
        }

        return implode('', $words);
    }
}