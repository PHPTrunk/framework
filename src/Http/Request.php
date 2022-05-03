<?php

namespace PHPTrunk\Http;

use PHPTrunk\Support\Arr;

class Request
{
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function path(): string
    {
        return strpos($_SERVER['REQUEST_URI'], '?')
            ? strstr($_SERVER['REQUEST_URI'], '?', true)
            : $_SERVER['REQUEST_URI'];
    }

    public function all(): array
    {
        return $_REQUEST;
    }

    public function only(string $keys)
    {
        return Arr::only($this->all(), $keys);
    }

    public function get(string $key, $default = null)
    {
        return Arr::get($this->all(), $key, $default);
    }
}
