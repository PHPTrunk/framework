<?php

namespace PHPTrunk\Validation;

use PHPTrunk\Validation\RulesMapper;

trait RulesResolver
{
    public static function make(array|string $rules)
    {
        $rules = is_array($rules) ? $rules : explode('|', $rules);

        return array_map(function ($rule) {
            if (is_string($rule)) {
                $rule = static::resolveRule($rule);
            }
            return $rule;
        }, $rules);
    }

    public static function resolveRule(string $rule)
    {
        $rule       = explode(':', $rule);
        $options    = explode(',', end($rule));

        return RulesMapper::resolve(array_shift($rule), $options);
    }
}
