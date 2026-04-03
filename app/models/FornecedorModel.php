<?php

class FornecedorModel
{
    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }

    public function insert(array $dados): mixed
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("INSERT INTO tb_fornecedor (for_cnpj, for_nome, end_id) VALUES (:cnpj, :nome, :endereco)");

            $stmt->execute([
                ':cnpj' => $dados['cnpj'],
                ':nome' => $dados['nome'],
                ':endereco' => $dados['endereco_id'],
            ]);

            $this->db->commit();

            return $this->db->lastInsertId();
        } catch (\Exception $e) {

            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Erro ao cadastrar o Fornecedor");
        };
    }

    public function selectAll(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT f.*, e.*, FROM tb_fornecedor f INNER JOIN tb_endereco e ON f.end_id = e.end_id");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {

            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Erro ao listar Fornecedores");
        }
    }

    public function selectById($id): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_fornecedor WHERE for_id = :id");

            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Erro ao buscador o forncedor informado");
        };
    }

    public function selectByCnpj($cnpj): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_fornecedor WHERE for_cnpj = :cnpj");

            $stmt->execute([':cnpj' => $cnpj]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Erro ao busacar o fornecedor informado");
        }
    }

    public function update($dados, $id): void
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("UPDATE tb_fornecedor SET for_cnpj = :cnpj, for_nome = :nome WHERE for_id = :id");

            $stmt->execute([
                ':nome' => $dados['nome'],
                ':cnpj' => $dados['cnpj'],
                ':id' => $id
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Erro ao atualizar dados do fornecedor");
        };
    }
}
