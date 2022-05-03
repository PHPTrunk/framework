<?php

namespace PHPTrunk\Validation;

class ErrorBag
{
    protected array  $errors         = [];

    public function all()
    {
        return $this->errors;
    }

    public function add($field, $message)
    {
        $this->errors[$field][] = $message;
    }
}
