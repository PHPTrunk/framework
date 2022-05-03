<?php

namespace PHPTrunk\Support;

class Form
{
    protected string $errorBagKey;

    protected static $form_instances_pool = [];

    protected function __construct(string $errorBagKey = 'errors')
    {
        $this->errorBagKey = $errorBagKey;
    }

    public static function getInstance(string $errorBagKey = 'errors'): Form
    {
        if (!isset(static::$form_instances_pool[$errorBagKey])) {
            static::$form_instances_pool[$errorBagKey] = new Form($errorBagKey);
        }
        return static::$form_instances_pool[$errorBagKey];
    }

    public function hasErrors(): bool
    {
        return session()->hasFlashMessage($this->errorBagKey);
    }

    public function getErrors(): array
    {
        return session()->getFlashMessage($this->errorBagKey);
    }
}