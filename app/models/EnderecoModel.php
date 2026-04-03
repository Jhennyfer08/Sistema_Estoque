<?php

class EnderecoModel
{
    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }

    public function insert(array $dados): int
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tb_endereco(end_cep, end_rua, end_num, end_bairro, end_cidade, end_estado) VALUES (:cep, :rua, :numero, :bairro, :cidade, :estado)");
            $stmt->execute([
                ':cep' => $dados['cep'],
                ':rua' => $dados['rua'],
                ':numero' => $dados['numero'],
                ':bairro' => $dados['bairro'],
                ':cidade' => $dados['cidade'],
                ':estado' => $dados['estado'],
            ]);

            return $this->db->lastInsertId();
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            exit;
        }
    }

    public function update(array $dados, $id): void
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("UPDATE tb_endereco SET end_cep = :cep, end_rua = :rua, end_numero = :numero, end_bairro = :bairro, end_cidade = :cidade, end_estado = :estado WHERE end_id = :id");

            $stmt->execute([
                ':cep' => $dados['cep'],
                ':rua' => $dados['rua'],
                ':numero' => $dados['numero'],
                ':bairro' => $dados['bairro'],
                ':cidade' => $dados['cidade'],
                ':estado' => $dados['estado'],
                ':id' => $id
            ]);

            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao atualizar endereço (update). 402');
        }
    }
}
