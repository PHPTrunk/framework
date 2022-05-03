<?php

namespace PHPTrunk\Support;

class Field
{
    protected string $field_name;
    protected string $errorBagKey;
    protected string $oldDataKey;

    protected static $field_instances_pool = [];

    protected function __construct(string $field_name, string $errorBagKey = 'errors', string $oldDataKey = 'old')
    {
        $this->field_name   = $field_name;
        $this->errorBagKey  = $errorBagKey;
        $this->oldDataKey   = $oldDataKey;
    }

    public static function getInstance(string $field_name, string $errorBagKey = 'errors', $oldDataKey = 'old'): Field
    {
        if (!isset(static::$field_instances_pool[$field_name])) {
            static::$field_instances_pool[$field_name] = new Field($field_name, $errorBagKey, $oldDataKey);
        }
        return static::$field_instances_pool[$field_name];
    }

    public function hasErrors(): bool
    {
        return Arr::has(session()->getFlashMessage($this->errorBagKey), $this->field_name);
    }

    public function getErrors(): array
    {
        return Arr::get(session()->getFlashMessage($this->errorBagKey), $this->field_name);
    }

    public function getFirstError(): string
    {
        return Arr::first($this->getErrors($this->field_name));
    }

    public function oldValue(): string
    {
        return Arr::get(session()->getFlashMessage($this->oldDataKey), $this->field_name) ?? '';
    }
}