<?php

namespace PHPTrunk\Database;

use PHPTrunk\Database\Contracts\DatabaseDriver;

class DB
{
    protected DatabaseDriver $driver;

    public function __construct(DatabaseDriver $driver)
    {
        $this->driver = $driver;
    }

    public function connect()
    {
        return $this->driver->connect();
    }

    public function query(string $query, array $bindings = [])
    {
        return $this->driver->query($query, $bindings);
    }

    public function create(array $data)
    {
        return $this->driver->create($data);
    }

    public function select(string $columns = '*', string $filter = null)
    {
        return $this->driver->select($columns, $filter);
    }

    public function update($id, array $data)
    {
        return $this->driver->update($id, $data);
    }

    public function delete($id)
    {
        return $this->driver->delete($id);
    }
}
