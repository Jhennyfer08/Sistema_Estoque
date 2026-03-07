<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'db_estoque');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

class Database
{
    private $connection;

    public function __construct()
    {
        $this->connectDB();
    }

    public function connectDB(): void
    {
        $this->connection = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASSWORD,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function getConnection(): PDO
    {
        echo ('<script>console.log("Conexão com o banco efetuada com sucesso!")</script>');
        return $this->connection;
    }
}

$db = new Database();
