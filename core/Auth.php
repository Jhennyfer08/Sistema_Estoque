<?php

class Auth
{
    //Se não existir uma sessão, inicia uma
    public function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    } 

    //Atribui o usuário que fez o login á sessão
    public function login($usuario): void
    {
        $this->start();
        $_SESSION['usuario'] = $usuario;
    }

    //Apaga a sessão
    public function logout(): void
    {
        $this->start();
        session_destroy();
    }

    //Checa se o usuário está logado
    public function check(): bool
    {
        $this->start();
        return isset($_SESSION['usuario']);
    }

    //Retorna os dados do usuário logado
    public function user(): mixed
    {
        $this->start();
        return $_SESSION['usuario'] ?? null;
    }
}
