<?php

namespace PHPTrunk\Support;

use ArrayAccess;

class Arr
{
    public static function accessible($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    public static function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }
        return array_key_exists($key, $array);
    }

    /**
    * Get value from array by key
    *
    * @param array $array
    * @param string $key
    * @param mixed $default
    * @return mixed
    */
    public static function get($array, $key, $default = null)
    {
        if (!static::accessible($array)) {
            return value($default);
        }

        if (is_null($key)) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        if (mb_strpos($key, '.') === false) {
            return $array[$key] ?? value($default);
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !static::exists($array, $segment)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
    * Set value to array by key
    *
    * @param array $array
    * @param string $key
    * @param mixed $value
    * @return array
    */
    public static function set(&$array, $key, $value)
    {
        if (is_null($key)) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    public static function add($array, $key, $value)
    {
        if (is_null(static::get($array, $key))) {
            static::set($array, $key, $value);
        }

        return $array;
    }

    /**
    * Check if key exists in array
    *
    * @param array $array
    * @param string $key
    * @return bool
    */
    public static function has($array, $key)
    {
        if (empty($array) || is_null($key)) {
            return false;
        }

        if (static::exists($array, $key)) {
            return true;
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !static::exists($array, $segment)) {
                return false;
            }

            $array = $array[$segment];
        }

        return true;
    }

    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    public static function except($array, $keys)
    {
        return array_diff_key($array, array_flip((array) $keys));
    }

    public static function forget(&$array, $keys)
    {
        $original = &$array;

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return;
        }

        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if (static::exists($array, $key)) {
                unset($array[$key]);
                continue;
            }

            $parts = explode('.', $key);

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (static::exists($array, $part) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue;
                }
            }

            unset($array[array_shift($parts)]);
        }
    }

    public static function flatten($array, $depth = INF)
    {
        $result = [];

        foreach ($array as $item) {
            if (!is_array($item)) {
                $result[] = $item;
            } elseif ($depth === 1) {
                $result = array_merge($result, array_values($item));
            } else {
                $result = array_merge($result, static::flatten($item, $depth - 1));
            }
        }

        return $result;
    }

    public static function first(array $array)
    {
        return reset($array);
    }

    public static function last(array $array)
    {
        return end($array);
    }
}
