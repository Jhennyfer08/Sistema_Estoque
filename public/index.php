<?php

require_once __DIR__. '/../core/Database.php';
require_once __DIR__. '/../core/Router.php';

$db = new Database();

try {
    $connection = $db->getConnection();
    echo ('<script>console.log("Conexão com o banco efetuada com sucesso!")</script>');
} catch (\Exception $th) {
    throw new Exception(" A Conexão com o banco não foi efetuada! 402");
}