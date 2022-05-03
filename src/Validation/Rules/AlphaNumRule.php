<?php

namespace PHPTrunk\Validation\Rules;

use PHPTrunk\Validation\Contracts\Rule;

class AlphaNumRule extends Rule
{
    public function apply($field, $value, $data)
    {
        return ctype_alnum($value);
    }

    public function message($field)
    {
        return sprintf('The %s field must contain only letters and numbers only!', $field);
    }
}
