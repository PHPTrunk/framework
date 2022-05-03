<?php

namespace PHPTrunk\Http;

use PHPTrunk\Support\Arr;

class Response
{
    public function status(int $statusCode): void
    {
        http_response_code($statusCode);
    }

    public function send(): void
    {
        exit;
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
        return $this->send();
    }

    public function back()
    {
        if(Arr::has($_SERVER,'HTTP_REFERER')){
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        $this->redirect('/');
    }

    public function backWithErrors(array $errors, string $errorBagKey = 'errors', $oldDataKey = 'old'): void
    {
        $this->status(422);
        session()->setFlashMessage($errorBagKey, $errors);
        session()->setFlashMessage($oldDataKey, request()->all());

        back();
    }
}
