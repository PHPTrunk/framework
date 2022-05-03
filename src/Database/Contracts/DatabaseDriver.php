<?php

namespace PHPTrunk\Database\Contracts;

abstract class DatabaseDriver
{
    public abstract function connect() : \PDO;

    public abstract function query(string $query, array $bindings = []);

    public abstract function create(array $data);

    public abstract function select(string|array $columns = '*', string $filter = null);

    public abstract function update($id, array $data);

    public abstract function delete($id);
}