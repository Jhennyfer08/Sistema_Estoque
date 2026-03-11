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
            $stmt = $this->db->prepare('INSERT INTO tb_usuario (usu_codigo, usu_cpf, usu_nome, usu_data_nasc, usu_data_cont, usu_email, usu_login, usu_senha, usu_status, usu_permissao,, end_id, set_id, fun_id) VALUES (:matricula, :cpf, :nome, :data_nasc, :data_contrato, :email, :usu_login :senha, :modo, :permissao, :endereco, :setor, :funcao)');

            $stmt->execute([
                ':matricula' => $dados['matricula'],
                ':cpf' => $dados['cpf'],
                ':nome' => $dados['nome'],
                ':data_nasc' => $dados['cpf'],
                ':data_contrato' => $dados['data_contrato'],
                ':email' => $dados['email'],
                ':usu_login' => $dados['matricula'],
                password_hash($dados['senha'], PASSWORD_DEFAULT),
                ':modo' => $dados['modo'],
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

    public function update(array $dados, $id): array
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("UPDATE tb_ usuario SET 
         usu_codigo = :matricula,
         usu_cpf = :cpf,
         usu_nome = :nome,
         usu_data_nasc = :data_nasc,
         usu_data_cont = :data_contrato,
         usu_email = :email,
         usu_senha = :senha,
         usu_modo = :modo,
         usu_permissao = :permissao,
         usu_setor = :setor,
         usu_funcao = :funcao,
         usu_endereco = :endereco_id,
         WHERE usu_id = :id
        ");

            $stmt->execute([
                ':matricula' => $dados['matricula'],
                ':cpf' => $dados['cpf'],
                ':nome' => $dados['nome'],
                ':data_nasc' => $dados['data_nasc'],
                ':data_contrato' => $dados['data_contrato'],
                ':email' => $dados['email'],
                ':senha' => $dados['senha'],
                ':modo' => $dados['modo'],
                ':permissao' => $dados['permissao'],
                ':setor' => $dados['setor'],
                ':funcao' => $dados['funcao'],
                ':endereco_id' => $dados['endereco_id'],
                ':id' => $id
            ]);

            $this->db->commit();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao buscar os dados (selectById). 402');
        }
    }

    public function delete($id): bool
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("DELETE * FROM tb_usuario WHERE usu_id = :id");
            $stmt->execute([':id' => $id]);
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao deletar os dados (delete). 402');
        }
    }
}

# ERRO DATABASE 401
# ERRO MODEL 402
# ERRO CONTROLLER 403