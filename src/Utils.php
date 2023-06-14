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

    public static function classNameToEvent(string $class): string
    {
        $array = explode('\\', $class);
        $string = end($array);
        $string = preg_replace('/([a-z])([A-Z])/', '$1_$2', $string);
        $string = strtolower($string);
        return $string;
    }

    public static function validateRules(object $event, array $rules): bool
    {
        foreach ($rules as $rule) {
            if (!$rule->passes($event)) {
                return false;
            }
        }

        return true;
    }

    public static function validateCommand(array $commands, string $prefix, string $text): bool|array
    {
        if (!str_starts_with($text, $prefix)) {
            return false;
        }

        foreach ($commands as $command) {
            if (explode(' ', substr($text, strlen($prefix)))[0] == $command) {
                return ['command' => $command, 'arguments' => explode(' ', substr($text, strlen($prefix . $command) + 1))];
            }
        }

        return false;
    }
}