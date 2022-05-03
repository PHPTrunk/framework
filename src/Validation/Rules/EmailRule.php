<?php

namespace PHPTrunk\Validation\Rules;

use PHPTrunk\Validation\Contracts\Rule;

class EmailRule extends Rule
{
    public function apply($field, $value, $data)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function message($field)
    {
        return "The $field is not a valid email address";
    }
}