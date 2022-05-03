<?php

namespace PHPTrunk\View;

class View
{
    public static function render($view, $params = [])
    {
        $layout = self::getBaseContent();
        $content_to_injected = self::getViewContent($view, params: $params);

        return str_replace('{{content}}', $content_to_injected, $layout);
    }

    protected static function getBaseContent()
    {
        ob_start();

        include view_path() . 'layouts/main.view.php';

        return ob_get_clean();
    }

    public static function makeError($error)
    {
        self::getViewContent($error, true);
    }

    protected static function getViewContent($view, $isError = false, $params = [])
    {
        $path = $isError ? view_path() . 'errors/' : view_path();

        if (str_contains($view, '.')) {
            $views = explode('.', $view);

            foreach ($views as $view) {
                if (is_dir($path . $view)) {
                    $path = $path . $view . '/';
                }
            }
            $view = $path . end($views) . '.view.php';
        } else {
            $view = $path . $view . '.view.php';
        }

        extract($params);

        if ($isError) {
            include $view;
        } else {
            ob_start();
            include $view;
            return ob_get_clean();
        }
    }
}
