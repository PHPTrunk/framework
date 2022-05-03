<?php

namespace PHPTrunk\Validation;

use PHPTrunk\Support\Arr;
use PHPTrunk\Validation\ErrorBag;
use PHPTrunk\Validation\Contracts\Rule;

class Validator
{
    protected array     $data       = [];
    protected array     $rules      = [];
    protected array     $aliases    = [];
    protected ErrorBag  $errorBag;


    public function __construct(array $rules)
    {
        $this->rules    = $rules;
        $this->errorBag = new ErrorBag();
    }

    public function validate(array $data)
    {
        $this->data = $data;

        foreach ($this->rules as $field => $rules) {
            $rules = RulesResolver::make($rules);
            foreach ($rules as $rule) {
                $this->applyRule($field, $rule);
            }
        }
        return $this;
    }

    protected function applyRule($field, Rule $rule)
    {
        ! $rule->apply(
            $field,
            Arr::get($this->data, $field),
            $this->data
        )
        ?
        $this->errorBag->add(
            $field,
            $rule->message(
                $this->alias($field)
            )
        )
        :
        null;
    }

    public function passes()
    {
        return empty($this->errors());
    }

    public function fails()
    {
        return !$this->passes();
    }

    public function errors($key = null)
    {
        return ! $key ? $this->errorBag->all() : Arr::only($this->errorBag->all(), $key);
    }

    public function alias($field)
    {
        return $this->aliases[$field] ?? $field;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }
}
