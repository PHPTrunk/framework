<?php

namespace PHPTrunk\Validation\Rules;

use PHPTrunk\Validation\Contracts\Rule;

class MaxRule extends Rule
{
    protected int    $max;
    protected string $type;

    public function __construct(int $max)
    {
        $this->max = $max;
    }

    public function apply($field, $value, $data)
    {
        $this->type = gettype($value);

        switch($this->type) {
            case 'integer':
            case 'double':
                return $value <= $this->max;
            case 'string':
                return mb_strlen($value) <= $this->max;
            case 'array':
                return count($value) <= $this->max;
            default:
                return false;
        }
    }

    public function message($field)
    {
        switch($this->type) {
            case 'integer':
            case 'double':
                return sprintf(
                    'The %s field must be at most %d!',
                    $field,
                    $this->min
                );
            case 'string':
                return sprintf(
                    'The %s field must contain at most %d characters!',
                    $field,
                    $this->min
                );
            case 'array':
                return sprintf(
                    'The %s field must contain at most %d items!',
                    $field,
                    $this->min
                );
            default:
                return sprintf(
                    'The %s field data type is %s and this rule is applicable only to integer, double, string and array data types!',
                    $field,
                    $this->type
                );
        }
    }
}
