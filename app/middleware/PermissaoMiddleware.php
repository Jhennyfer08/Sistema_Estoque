<?php

require_once __DIR__ . '/../../core/Auth.php';

class PermissaoMiddleware
{
    private $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }
    
    public function handle($funcionarioPermitido = []): void
    {
        if (!$this->auth->check()) {
            header("Location: /login");
            exit;
        }

        $usuario = $this->auth->user();

        if (!in_array($usuario['usu_permissao'], $funcionarioPermitido)) {
            http_response_code(403);
            header('Location: /estoque/public/acesso-negado');
            exit;
        }
    }
}
