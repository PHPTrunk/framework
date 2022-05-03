<?php

namespace PHPTrunk\Support;

class Hash
{
    public static function password($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function checkPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function generateToken()
    {
        return bin2hex(random_bytes(32));
    }

    public static function needsRehash($hash)
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT);
    }
}
