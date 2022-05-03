<?php

namespace PHPTrunk\Validation\Rules;

use PHPTrunk\Validation\Contracts\Rule;

class BetweenRule extends Rule
{
    protected int    $min;
    protected int    $max;
    protected string $type;

    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function apply($field, $value, $data)
    {
        $this->type = gettype($value);

        switch($this->type) {
            case 'integer':
            case 'double':
                return $value >= $this->min && $value <= $this->max;
            case 'string':
                return mb_strlen($value) >= $this->min && mb_strlen($value) <= $this->max;
            case 'array':
                return count($value) >= $this->min && count($value) <= $this->max;
            default:
                return false;
        }
    }

    public function message($field)
    {
        switch ($this->type) {
            case 'integer':
            case 'double':
                return sprintf(
                    'The %s field must be between %d and %d!',
                    $field,
                    $this->min,
                    $this->max
                );
            case 'string':
                return sprintf(
                    'The %s field must contain between %d and %d characters!',
                    $field,
                    $this->min,
                    $this->max
                );
            case 'array':
                return sprintf(
                    'The %s field must contain between %d and %d items!',
                    $field,
                    $this->min,
                    $this->max
                );
            default:
                return sprintf(
                    'The %s field data type is %s and this rule is applicable only to integer, double, string and array data types!',
                    $field,
                    $this->type
                );
        };
    }
}