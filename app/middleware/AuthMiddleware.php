<?php

require_once __DIR__ . '/../../core/Auth.php';

class AuthMiddleware
{
    public $auth;

    public function __construct(){
        $this->auth = new Auth();
    }

    public function handle(): void
    {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }
    }
}
