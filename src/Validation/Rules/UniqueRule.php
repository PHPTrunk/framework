<?php

namespace PHPTrunk\Validation\Rules;

use PHPTrunk\Validation\Contracts\Rule;

class UniqueRule extends Rule
{

    protected string $table;
    protected string $column;

    public function __construct(string $table, string $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function apply($field, $value, $data)
    {
        // TODO: Implement apply() method.
        // return ! db()->table($this->table)->where($this->column, $value)->exists();
    }

    public function message($field)
    {
        return sprintf('The %s has already been taken!', $field);
    }
}