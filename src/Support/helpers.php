<?php

use App\Models\User;
use PHPTrunk\View\View;
use PHPTrunk\Support\Hash;

if (!function_exists('env')) {
    function env(string $key, string $default = null)
    {
        return getenv($key) ?? $default;
    }
}

if (! function_exists('view')) {
    function view($view, $data = [])
    {
        $viewInstance = new View();
        echo $viewInstance->render($view, $data);
        return '';
    }
}

if (! function_exists('redirect')) {
    function redirect($path)
    {
        header("Location: {$path}");
    }
}

if (! function_exists('dd')) {
    function dd($data)
    {
        highlight_string("<?php\n" . var_export($data, true) . ";\n?>");
        die();
    }
}

if (! function_exists('value')) {
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (! function_exists('base_path')) {
    function base_path($path = '')
    {
        return dirname(__DIR__) . '/../' . $path;
    }
}

if (! function_exists('view_path')) {
    function view_path($path = '')
    {
        return base_path('resources/views/' . $path);
    }
}

if (! function_exists('config_path')) {
    function config_path($path = '')
    {
        return base_path('config/' . $path);
    }
}

if (! function_exists('app')) {
    function app()
    {
        static $app_instance = null;
        if (! $app_instance) {
            $app_instance = new \PHPTrunk\Application\Application();
        }
        return $app_instance;
    }
}
if (! function_exists('request')) {
    function request()
    {
        return app()->request;
    }
}

if (! function_exists('response')) {
    function response()
    {
        return app()->response;
    }
}

if (! function_exists('config')) {
    function config(string|array $key = null, $default = null)
    {
        if (! $key) {
            return app()->config->all();
        }

        if (is_array($key)) {
            return app()->config->set($key);
        }
        return app()->config->get($key, $default);
    }
}

if (! function_exists('db')) {
    function db()
    {
        return app()->db;
    }
}

if (! function_exists('class_name')) {
    function class_name($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        return basename(str_replace('\\', '/', $class));
    }
}

if (! function_exists('bcrypt')) {
    function bcrypt(string $password)
    {
        return Hash::password($password);
    }
}

if (! function_exists('bcrypt_verify')) {
    function bcrypt_verify(string $password, string $hash)
    {
        return Hash::checkPassword($password, $hash);
    }
}

if (! function_exists('bcrypt_needs_rehash')) {
    function bcrypt_needs_rehash(string $hash)
    {
        return Hash::needsRehash($hash);
    }
}

if (! function_exists('bcrypt_generate_token')) {
    function bcrypt_generate_token()
    {
        return Hash::generateToken();
    }
}

if (! function_exists('bcrypt_hash_check')) {
    function bcrypt_hash_check(string $password, string $hash)
    {
        return Hash::checkPassword($password, $hash);
    }
}

if (! function_exists('session')) {
    function session()
    {
        return app()->session;
    }
}

if(! function_exists('request')) {
    function request(string|array $keys = null, $default = null)
    {
        if (! $keys) {
            return app()->request->all();
        }

        if (is_array($keys)) {
            return app()->request->only($keys);
        }
        return app()->request->get($keys, $default);
    }
}

if(! function_exists('response')) {
    function response($data = null, int $status = 200, array $headers = [])
    {
        return app()->response->set($data, $status, $headers);
    }
}

if(! function_exists('redirect')) {
    function redirect($path, int $status = 302, array $headers = [])
    {
        return response()->redirect($path, $status, $headers);
    }
}

if(! function_exists('abort')) {
    function abort(int $status, string $message = null, array $headers = [])
    {
        return response()->abort($status, $message, $headers);
    }
}

if(! function_exists('back')) {
    function back(int $status = 302)
    {
        return response()->back($status);
    }
}

if(! function_exists('backWithErrors')){
    function backWithErrors(array $errors, string $errorBagKey = 'errors', $oldDataKey = 'old')
    {
        return response()->backWithErrors($errors, $errorBagKey, $oldDataKey);
    }
}

if(! function_exists('form')){
    function form(string $errorBagKey = 'errors'){
        return \PHPTrunk\Support\Form::getInstance($errorBagKey);
    }
}

if(! function_exists('field')){
    function field(string $name, string $errorBagKey = 'errors', string $oldDataKey = 'old'){
        return \PHPTrunk\Support\Field::getInstance($name, $errorBagKey, $oldDataKey);
    }
}