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
$uri = trim($uri, '/');

$partes = explode('/', $uri);

if (count($partes) > 2) {
    $parametro = $partes[2];
    $rotaBase = $partes[0] . '/' . $partes[1];
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
    'login' => [
        'controller' => UsuarioController::class,
        'metodo' => 'login',
        'permissao' => ['A', 'F']
    ],

    //LISTAGEM DE USUÁRIOS
    'usuario/listar' => [
        'controller' => UsuarioController::class,
        'metodo' => 'list',
        'permissao' => ['A']
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

];

if (!isset($rotas[$rotaBase])) {
    http_response_code(404);
    exit('Página não encontrada.');
}

$controllerNome = $rotas[$rotaBase]['controller'];
$metodo = $rotas[$rotaBase]['metodo'];

// (new Controller-> Método)
$controller = new $controllerNome($connection);

if ($parametro) {
    $controller->$metodo($parametro);
} else {
    $controller->$metodo();
}





//$auth = new Auth();

// if (!$auth->check()) {
//     header('Location: /estoque/public/login');
//     exit;
// }

// $usuario = $auth->user();
// $funcionarioPermitido = $rotas[$rotaBase]['permissao'];

// if (!in_array($usuario['usu_permissao'], $funcionarioPermitido)) {
//     header('Location: /estoque/public/home');
//     exit;
// }
