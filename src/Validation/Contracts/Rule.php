<?php

namespace PHPTrunk\Validation\Contracts;

abstract class Rule
{
    abstract public function apply($field, $value, $data);

    abstract public function message($field);
}
