<?php
namespace PHPTrunk\Validation\Rules;

use PHPTrunk\Validation\Contracts\Rule;

class ConfirmedRule extends Rule
{
    public function apply($field, $value, $data)
    {
        return $value === $data[$field . '_confirmation'];
    }

    public function message($field)
    {
        return sprintf('The %s field must match the %s field!', $field, $field . '_confirmation');
    }
}