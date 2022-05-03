<?php

namespace PHPTrunk\Application;

use PHPTrunk\Database\DB;
use PHPTrunk\Http\Request;
use PHPTrunk\Http\Response;
use PHPTrunk\Routing\Route;
use PHPTrunk\Support\Config;
use PHPTrunk\Support\Session;
use PHPTrunk\Database\Drivers\MySQLDriver;

class Application
{
    protected Request   $request;
    protected Response  $response;
    protected Config    $config;
    protected Route     $route;
    protected DB        $db;
    protected Session   $session;

    public function __construct()
    {
        $this->request    = new Request;
        $this->response   = new Response;
        $this->config     = new Config($this->loadConfigFiles());
        $this->route      = new Route($this->request, $this->response);
        $this->db         = new DB($this->getDatabaseDriver());
        $this->session    = new Session;
    }

    protected function getDatabaseDriver()
    {
        switch (env('DB_DRIVER')) {
            case 'mysql':
                return new MySQLDriver();
            default:
                return new MySQLDriver();
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    public function run()
    {
        $this->db->connect();
        $this->route->resolve();
    }

    protected function loadConfigFiles()
    {
        $config_files = scandir(config_path());

        $config = [];

        foreach ($config_files as $config_file) {
            if ($config_file === '.' || $config_file === '..') {
                continue;
            }

            $filename = explode('.', $config_file)[0];

            $config[$filename] = array_merge(
                $config,
                require config_path($config_file)
            );
        }
        return $config;
    }
}
