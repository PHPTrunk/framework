<?php

namespace PHPTrunk\Database\Syntaxes;

use PHPTrunk\Database\Model;

class MySQLSyntax
{
    public static function buildInsertQuery(array $keys)
    {
        $columns    = implode(', ', $keys);
        $values     = implode(', ', array_map(function ($value) {
            return ':' . $value;
        }, $keys));

        return "INSERT INTO " . Model::getTableName() . " ({$columns}) VALUES ({$values})";
    }

    public static function buildSelectQuery(string|array $columns = '*', string $filter = null)
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $query = "SELECT {$columns} FROM " . Model::getTableName();
        if ($filter) {
            $query .= ' WHERE ' . $filter;
        }
        return $query;
    }

    public static function buildUpdateQuery(array $keys)
    {
        $columns    = implode(', ', array_map(function ($value) {
            return $value . ' = :' . $value;
        }, $keys));

        return "UPDATE " . Model::getTableName() . " SET {$columns} WHERE id = :id";
    }

    public static function buildDeleteQuery()
    {
        return "DELETE FROM " . Model::getTableName() . " WHERE id = :id";
    }
}
