<?php

namespace PHPTrunk\Validation\Rules;

use PHPTrunk\Validation\Contracts\Rule;

class RequiredRule extends Rule
{
    public function apply($field, $value, $data)
    {
        return ! empty($value);
    }

    public function message($field)
    {
        return sprintf('The %s field is required!', $field);
    }
}
