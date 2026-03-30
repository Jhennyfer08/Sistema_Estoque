<?php

require_once __DIR__ . '/../models/UsuarioModel.php';
require_once __DIR__ . '/../../core/Auth.php';

class AuthController
{
    private $usuarioModel;
    private $auth;

    public function __construct(PDO $connection)
    {
        $this->usuarioModel = new UsuarioModel($connection);
        $this->auth = new Auth();
    }

    public function index()
    {
        require_once __DIR__ . '/../views/index.php';
    }
    public function login()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                exit;
            }

            $dados = $this->dadosAuth();
            $erros = $this->validarDados($dados);

            $login = $dados['login'];
            $email = $dados['email'];
            $senha = $dados['senha'];


            $usuario = $this->usuarioModel->login($login, $email);

            if (!$usuario || !password_verify($senha, $usuario['usu_senha'])) {
                $this->auth->setFlash('erro_login', 'Login ou senha inválidos! Tente novamente com os dados corretos.');

                $this->auth->setFlash('old_info', [
                    'login' => $dados['login'],
                    'email' => $dados['email']
                ]);

                header('Location: /estoque/public/login');
                exit;
            }

            $this->auth->login([
                'id' => $usuario['usu_id'],
                'login' => $usuario['usu_codigo'],
                'nome' => $usuario['usu_nome'],
                'email' => $usuario['usu_email'],
                'setor' => $usuario['set_id'],
                'funcao' => $usuario['fun_id'],
                'permissao' => $usuario['usu_permissao'],
            ]);

            header('Location: /estoque/public/home');
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            $this->auth->setFlash('erro_login', 'Erro interno ao tentar logar.');
            header('Location: /estoque/public/login');
            exit;
        }
    }

    public function home()
    {
        try {
            require_once __DIR__ . '/../views/home/home.php';
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Error("Login inválido. 403");
        }
    }

    public function logout()
    {
        $this->auth->logout();

        header('Location: /estoque/public/login');
        exit;
    }

    public function acessoNegado()
    {
        require_once __DIR__ . '/../views/error_pages/403.php';
    }

    public function paginaNaoEncontrada()
    {
        require_once __DIR__ . '/../views/error_pages/404.php';
    }

    public function dadosAuth(): array
    {
        $dados = [
            'login' => trim($_POST['usu_login'] ?? null),
            'email' => trim($_POST['usu_email'] ?? null),
            'senha' => trim($_POST['usu_senha'] ?? null),
        ];

        return $dados;
    }

    public function validarDados(array $dados): array
    {
        $erros = [];

        if (!preg_match('/^\d{8}$/', $dados['login'])) {
            $erros[] = "Código de matrícula inválido. É preciso ter 8 números";
        }

        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $erros[] = "Email inválido";
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $dados['senha'])) { //Colocar o obrigatório de 8 caracteres, uma letra maiúscula e um número
            $erros[] = "Senha inválida";
        }

        return $erros;
    }
}
