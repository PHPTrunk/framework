<?php

namespace PHPTrunk\Support;

class Session
{
    public function __construct()
    {
        $flashMessages = $_SESSION['flash_messages'] ?? [];

        foreach ($flashMessages as $key => &$message) {
            $message['remove'] = true;
        }

        $_SESSION['flash_messages'] = $flashMessages;
    }
    /**
       * @param string $key
       * @param mixed $value
       */
    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): ?string
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * @param string $key
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * @return bool
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @return void
     */
    public static function setFlashMessage(string $key, string|array $message): array
    {
        return $_SESSION['flash_messages'][$key] = [
            'remove' => false,
            'content' => $message
        ];
    }

    /**
     * @return array
     */
    public static function getFlashMessage(string $key): ?array
    {
        return  $_SESSION['flash_messages'][$key]['content'] ?? null;
    }

    public static function hasFlashMessage(string $key): bool
    {
        return isset($_SESSION['flash_messages'][$key]);
    }

    /**
     * @return void
     */
    public static function removeFlashMessage(string $key): void
    {
        $_SESSION['flash_messages'][$key]['remove'] = true;
    }

    /**
     * @return void
     */
    protected function removeFlashMessages(): void
    {
        $flashMessages = $_SESSION['flash_messages'] ?? [];

        foreach ($flashMessages as $key => $message) {
            if ($message['remove']) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION['flash_messages'] = $flashMessages;
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        $this->removeFlashMessages();
    }
}
