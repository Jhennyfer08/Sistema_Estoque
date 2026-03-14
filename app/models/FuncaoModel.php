<?php

class FuncaoModel
{

    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }

    public function insert($nome): int
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tb_funcao(fun_nome) VALUES (:nome)");
            $stmt->execute([':nome' => $nome]);

            return $this->db->lastInsertId();
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            exit;
        }
    }

    public function selectAll(): array
    {

        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_funcao");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            exit;
        }
    }

    public function selectById($id): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_funcao WHERE fun_id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao selecionar os dados dos funcaes (selectAll). 402');
        }
    }
}
