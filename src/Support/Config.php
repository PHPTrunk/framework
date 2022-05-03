<?php

namespace PHPTrunk\Support;

class Config implements \ArrayAccess
{
    protected $config = [];

    public function __construct($config)
    {
        foreach ($config as $key => $value) {
            $this->config[$key] = $value;
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->config[$offset]);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->config[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->config[$offset]);
    }

    public function offsetGet(mixed $offset)
    {
        return $this->config[$offset];
    }

    public function has(string $key): bool
    {
        return Arr::has($this->config, $key);
    }

    public function exists(string $key): bool
    {
        return Arr::exists($this->config, $key);
    }

    public function set(string|array $key, $value): void
    {
        $data = is_array($key) ? $key : [$key => $value];
        foreach ($data as $key => $value) {
            Arr::set($this->config, $key, $value);
        }
    }

    public function get(string|array $key, $default = null)
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }

        return Arr::get($this->config, $key, $default);
    }

    public function getMany(array $keys, $default = null)
    {
        $values = [];

        foreach ($keys as $key => $default) {
            if (is_int($key)) {
                [$key, $default] = [$default, null];
            }
            $values[$key] = Arr::get($this->config, $key, $default);
        }

        return $values;
    }

    public function all(): array
    {
        return $this->config;
    }
}
