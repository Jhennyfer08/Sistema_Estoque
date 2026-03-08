<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';

$db = new Database();
$conn = $db->getConnection();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace($uri, '/estoque/public/', '');
$uri = trim($uri, '/');

$partes = explode('/', $uri);

if (count($partes) > 2) {
    $parametro = $partes[2];
    $rotaBase = $partes[0] . '/' . $partes[1];
} else {
    $parametro = null;
    $rotaBase = $partes;
}


/*Rota = [
    controller => Controller::class,
    metodo => Método,
    permissao => Permissão ['A', 'F'] A = Almoxarifado, F = Funcionário
]*/
$rotas = [
    'login' => [
        'controller' => UsuarioController::class,
        'metodo' => 'login',
        'permissao' => ['A', 'F']
    ],

    'home' => [
        'controller' => UsuarioController::class,
        'metodo' => 'index',
        'permissao' => ['A', 'F']
    ],

    '/cadastro' => [
        'controller' => UsuarioController::class,
        'metodo' => '',
        'permissao' => ['A']
    ],

    '/cadastro/usuario' => [
        'controller' => UsuarioController::class,
        'metodo' => 'create',
        'permissao' => ['A']
    ],

    '/cadastro/usuario/enviar' => [
        'controller' => UsuarioController::class,
        'metodo' => 'store',
        'permissao' => ['A']
    ],
];

if (!isset($rotas[$rotaBase])) {
    http_response_code(404);
    exit('Página não encontrada.');
}

$auth = new Auth();

if (!$auth->check()) {
    header('Location: /estoque/public/login');
    exit;
}

$usuario = $auth->user();
$funcionarioPermitido = $rotas[$rotaBase]['permissao'];

if (!in_array($usuario['usu_permissao'], $funcionarioPermitido)) {
    header('Location: /estoque/public/home');
    exit;
}

$controllerNome = $rotas[$rotaBase]['controller'];
$metodo = $rotas[$rotaBase]['metodo'];

// (new Controller-> Método)
$controller = new $controllerNome($conn);

if (isset($parametro)) {
    (new $controller->$metodo($parametro));
} else {
    (new $controller->$metodo());
}