<?php

class UsuarioModel
{

    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }

    public function insert(array $dados): void
    {

        $this->db->beginTransaction();
        try {
            $stmt = $this->db->prepare('INSERT INTO tb_usuario (usu_codigo, usu_cpf, usu_nome, usu_data_nasc, usu_data_cont, usu_email, usu_senha, usu_status, usu_permissao, usu_setor_id, usu_funcao_id, usu_endereco_id) VALUES (:matricula, :cpf, :nome, :data_nasc, :data_contrato, :email, :senha, :status, :permissao, :setor, :funcao, :endereco)');

            $stmt->execute([
                ':matricula' => $dados['matricula'],
                ':cpf' => $dados['cpf'],
                ':nome' => $dados['nome'],
                ':data_nasc' => $dados['cpf'],
                ':data_contrato' => $dados['data_contrato'],
                ':email' => $dados['email'],
                password_hash($dados['senha'], PASSWORD_DEFAULT),
                ':status' => $dados['status'],
                ':permissao' => $dados['permissao'],
                ':setor' => $dados['setor_id'],
                ':funcao' => $dados['funcao_id'],
                ':endereco' => $dados['endereco_id']
            ]);

            $this->db->commit();
        } catch (\Exception $e) {

            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao cadastrar os dados (insert). 402');
        }
    }

    public function selectAll(): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_usuario");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao buscar os dados (selectAll). 402');
        }
    }

    public function selectById($id): array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM tb_usuario WHERE usu_id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao buscar os dados (selectById). 402');
        }
    }
}

# ERRO DATABASE 401
# ERRO MODEL 402
# ERRO CONTROLLER 403