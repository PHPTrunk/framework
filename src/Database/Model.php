<?php

namespace PHPTrunk\Database;

use PHPTrunk\Support\Str;

abstract class Model
{
    protected static $instance;
    protected string $table;

    public static function create(array $data)
    {
        self::$instance = static::class;
        return db()->create($data);
    }

    public static function select(string $columns = '*', array $filter = null)
    {
        self::$instance = static::class;
        return db()->select($columns, $filter);
    }

    public static function update($id, array $data)
    {
        self::$instance = static::class;
        return db()->update($id, $data);
    }

    public static function delete($id)
    {
        self::$instance = static::class;
        return db()->delete($id);
    }

    public static function getModel()
    {
        return self::$instance;
    }

    public static function getTableName()
    {
        return Str::plural(Str::lower(
            str_replace(
                'Model',
                '',
                class_name(self::$instance)
            )
        ));
    }

    public static function all(string $columns = '*')
    {
        self::$instance = static::class;
        return db()->select($columns);
    }

    public static function find($id, string $columns = '*')
    {
        self::$instance = static::class;
        return db()->select($columns, "id = $id")[0];
    }

    public static function where(string $column, string $operator, string $value, string $columns = '*')
    {
        self::$instance = static::class;
        return db()->select($columns, "$column $operator '%$value%'");
    }
}
