<?php

class MaterialModel
{
    private $db;

    public function __construct($connection)
    {
        $this->db = $connection;
    }

    public function insert(array $dados): mixed
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("INSERT INTO tb_material (mat_codigo, mat_nome, mat_quantidade, mat_valor, mat_modo, uni_id) VALUES (:codigo, :nome, :quantidade, :valor, :modo, :uni_id)");

            $stmt->execute([
                ':codigo' => $dados['codigo'],
                ':nome' => $dados['nome'],
                ':quantidade' => $dados['quantidade'],
                ':valor' => $dados['valor'] ?? null,
                ':modo' => $dados['modo'],
                ':uni_id' => $dados['uni_id'],
            ]);

            $this->db->commit();

            return $this->db->lastInsertId();
        } catch (\Exception $e) {

            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao inserir material. 403');
        }
    }

    public function selectAll(): array
    {
        try {
            $stmt = $this->db->prepare('SELECT * FROM tb_material ORDER BY mat_id DESC');

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao listar materiais (selectAll). 403');
        }
    }

    public function selectById($id): array|null
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_material WHERE mat_id = :id");

            $stmt->execute([
                'mat_id' => $id
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao buscar material (selectById). 403');
        }
    }

    public function selectByCodigo($codigo)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_material WHERE mat_codigo = :codigo");

            $stmt->execute([
                ':codigo' => $codigo
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao buscar material por código. 403');
        }
    }

    public function update($dados, $id)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("UPDATE tb_material SET mat_codigo = :codigo, mat_nome = :nome, mat_quantidade = :quantidade, mat_valor = :valor, mat_modo = :modo, uni_id = :uni_id WHERE mat_id = :id");

            $stmt->execute([
                ':codigo' => $dados['codigo'],
                ':nome' => $dados['nome'],
                ':quantidade' => $dados['quantidade'],
                ':valor' => $dados['valor'],
                ':modo' => $dados['modo'],
                ':uni_id' => $dados['uni_id'],
                ':id' => $id
            ]);

            $this->db->commit();
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao atualizar material (update). 402');
        }
    }
}
