<?php

namespace PHPTrunk\Database\Drivers;

use PHPTrunk\Support\Arr;
use PHPTrunk\Database\Model;
use PHPTrunk\Database\Syntaxes\MySQLSyntax;
use PHPTrunk\Database\Contracts\DatabaseDriver;

class MySQLDriver extends DatabaseDriver
{
    protected static $pdo;

    public function connect(): \PDO
    {
        if (!self::$pdo) {
            $dsn = 'mysql:host=' . config('database.host') . ';dbname=' . config('database.database');
            self::$pdo = new \PDO(
                $dsn,
                config('database.username'),
                config('database.password')
            );
        }
        return self::$pdo;
    }

    public function query(string $query, array $bindings = [])
    {
        $statement = self::$pdo->prepare($query);

        $statement->execute($bindings);

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $query      = MySQLSyntax::buildInsertQuery(array_keys($data));
        $statement  = self::$pdo->prepare($query);

        return $statement->execute($data);
    }

    public function select(string|array $columns = '*', string $filter = null)
    {
        $query      = MySQLSyntax::buildSelectQuery($columns, $filter);
        $statement  = self::$pdo->prepare($query);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, Model::getModel());
    }

    public function update($id, array $data)
    {
        $query      = MySQLSyntax::buildUpdateQuery(array_keys($data));
        $statement  = self::$pdo->prepare($query);

        $statement->execute(Arr::add($data, ':id', $id));

        return $statement;
    }

    public function delete($id)
    {
        $query      = MySQLSyntax::buildDeleteQuery();
        $statement  = self::$pdo->prepare($query);

        $statement->execute([':id' => $id]);

        return $statement;
    }
}
