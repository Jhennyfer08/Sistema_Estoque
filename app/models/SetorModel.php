<?php

class SetorModel
{

    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }

    public function insert(string $nome):int
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tb_setor(set_nome) VALUES (:nome)");
            $stmt->execute([':nome' => $nome]);

            return $this->db->lastInsertId();
            
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            exit;
        }
    }

    public function selectAll():array{
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_setor");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            exit;
        }
    }
}
