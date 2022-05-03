<?php

namespace PHPTrunk\Routing;

use App\Models\User;
use PHPTrunk\Http\Request;
use PHPTrunk\Http\Response;

class Route
{
    protected Request   $request;
    protected Response  $response;
    public static array $routesMap = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    public static function get(string $path, string $controller, string $action): void
    {
        self::$routesMap['GET'][$path] = [
            'controller'    => $controller,
            'action'        => $action,
        ];
    }

    public static function post(string $path, string $controller, string $action): void
    {
        self::$routesMap['POST'][$path] = [
            'controller'    => $controller,
            'action'        => $action,
        ];
    }

    public static function put(string $path, string $controller, string $action): void
    {
        self::$routesMap['PUT'][$path] = [
            'controller'    => $controller,
            'action'        => $action,
        ];
    }

    public static function delete(string $path, string $controller, string $action): void
    {
        self::$routesMap['DELETE'][$path] = [
            'controller'    => $controller,
            'action'        => $action,
        ];
    }

    public function resolve()
    {
        $controller_info = self::$routesMap[$this->request->method()][$this->request->path()] ?? null;

        if (!$controller_info) {
            response()->status(404);
            echo '<h1>404 Not Found</h1>';
            response()->send();
        }

        call_user_func_array([
            new $controller_info['controller'](),
            $controller_info['action']
        ], []);
    }
}
