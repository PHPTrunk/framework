<?php

namespace PHPTrunk\Validation;

use PHPTrunk\Validation\Rules\MaxRule;
use PHPTrunk\Validation\Rules\MinRule;
use PHPTrunk\Validation\Rules\UrlRule;
use PHPTrunk\Validation\Rules\EmailRule;
use PHPTrunk\Validation\Rules\UniqueRule;
use PHPTrunk\Validation\Rules\BetweenRule;
use PHPTrunk\Validation\Rules\AlphaNumRule;
use PHPTrunk\Validation\Rules\RequiredRule;
use PHPTrunk\Validation\Rules\ConfirmedRule;

trait RulesMapper
{
    protected static array $map = [
        'required'          => RequiredRule::class,
        'alpha_num'         => AlphaNumRule::class,
        'max'               => MaxRule::class,
        'min'               => MinRule::class,
        'max_length'        => MaxRule::class,
        'min_length'        => MinRule::class,
        'between'           => BetweenRule::class,
        'between_length'    => BetweenRule::class,
        'email'             => EmailRule::class,
        'url'               => UrlRule::class,
        'confirmed'         => ConfirmedRule::class,
        'unique'            => UniqueRule::class,
    ];


    public static function resolve(string $rule, array $options)
    {
        return new static::$map[$rule](...$options);
    }
}
