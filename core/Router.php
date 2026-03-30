<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Auth.php';

//Controllers
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_once __DIR__ . '/../app/controllers/MaterialController.php';
require_once __DIR__ . '/../app/controllers/MovimentacaoController.php';
require_once __DIR__ . '/../app/controllers/HistoricoController.php';

$db = new Database();
$connection = $db->getConnection();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/estoque/public/', '', $uri);
$uri = rtrim($uri, '/');

$partes = explode('/', $uri);

if (count($partes) > 2) {
    $rotaBase = $partes[0] . '/' . $partes[1] . (isset($partes[2]) ? '/' . $partes[2] : null);
    $parametro = $partes[3] ?? null;
} else {
    $parametro = null;
    $rotaBase = $uri;
}

/*Rota = [
    controller => Controller::class,
    metodo => Método,
    permissao => Permissão ['A', 'F'] A = Almoxarifado, F = Funcionário
]*/

$rotas = [

    //LOGIN

    'login' => [
        'controller' => AuthController::class,
        'metodo' => 'index',
        'permissao' => ['A', 'F']
    ],

    'auth/login' => [
        'controller' => AuthController::class,
        'metodo' => 'login',
        'permissao' => ['A', 'F']
    ],

    'home' => [
        'controller' => AuthController::class,
        'metodo' => 'home',
        'permissao' => ['A', 'F']
    ],

    //LISTAGEM DE USUÁRIOS
    'usuario/listar' => [
        'controller' => UsuarioController::class,
        'metodo' => 'list',
        'permissao' => ['A', 'F']
    ],

    //CADASTRO USUÁRIO
    'cadastro/usuario' => [
        'controller' => UsuarioController::class,
        'metodo' => 'create',
        'permissao' => ['A']
    ],

    'cadastro/usuario/enviar' => [
        'controller' => UsuarioController::class,
        'metodo' => 'store',
        'permissao' => ['A']
    ],

    //TRANFERÊNCIA DE MATERIAIS
    'caixa-de-entrada' => [
        'controller' => MovimentacaoController::class,
        'metodo' => 'caixaEntrada',
        'permissao' => ['A', 'F']
    ],

    'transferencia' => [
        'controller' => MovimentacaoController::class,
        'metodo' => 'transferencia',
        'permissao' => ['A', 'F']
    ],

    'transferencia/transferir' => [
        'controller' => MovimentacaoController::class,
        'metodo' => 'realizarTransferencia',
        'permissao' => ['A', 'F']
    ],

    'transferencia/aceitar' => [
        'controller' => MovimentacaoController::class,
        'metodo' => 'aceitarTransferencia',
        'permissao' => ['A', 'F']
    ],

    'transferencia/recusar' => [
        'controller' => MovimentacaoController::class,
        'metodo' => 'recusarTransferencia',
        'permissao' => ['A', 'F']
    ],

    'acesso-negado' => [
        'controller' => AuthController::class,
        'metodo' => 'acessoNegado',
        'permissao' => ['A', 'F']
    ],

    'pagina-nao-encontrada' => [
        'controller' => AuthController::class,
        'metodo' => 'paginaNaoEncontrada',
        'permissao' => ['A', 'F']
    ]

];


if (!isset($rotas[$rotaBase])) {
    header('Location: estoque/public/pagina-nao-encontrada');
    http_response_code(404);
}

// $auth = new Auth();

// $rotasLogin = ['auth/login', 'login'];

// if (!in_array($rotaBase, $rotasLogin)) {
//     if (!$auth->check()) {
//         header('Location: /estoque/public/login');
//         exit;
//     }
// }

// $usuario = $auth->user();
// $funcionarioPermitido = $rotas[$rotaBase]['permissao'];

// if (!in_array($usuario['usu_permissao'], $funcionarioPermitido)) {
//     header('Location: /estoque/public/acesso-negado');
//     exit;
// }

$controllerNome = $rotas[$rotaBase]['controller'];
$metodo = $rotas[$rotaBase]['metodo'];

// (new Controller-> Método)
$controller = new $controllerNome($connection);

if ($parametro) {
    $controller->$metodo($parametro);
} else {
    $controller->$metodo();
}


//CORRIGIR AS PERMISSÕES DAS ROTAS