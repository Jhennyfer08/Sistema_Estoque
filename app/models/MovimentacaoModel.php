<?php

class MovimentacaoModel
{
    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }

    public function registrarTransferencia($dados)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO tb_movimentacao(mov_tipo, mov_quantidade, mov_data, mov_status, tb_material_mat_id, tb_usuario_usu_id, mov_usuario_destino)
            VALUES ('transferencia', :qtd, NOW(), 'pendente', :material, :remetente, :destinatario)");

            $stmt->execute([
                ':qtd' => $dados['quantidade'],
                ':material' => $dados['material_id'],
                ':remetente' => $dados['remetente_id'],
                ':destinatario' => $dados['destinatario_id']
            ]);

            $this->db->commit();
            return $this->db->lastInsertId();
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Tranferência não realizada (transferencia). 402");
        }
    }

    public function aceitarTransferencia(int $mov_id): bool
    {
        try {
            $stmt =  $this->db->prepare("UPDATE tb_movimentacao SET mov_modo = :modo WHERE mov_id = :id");

            $stmt->execute([
                ':modo' => 'aceito',
                ':id' => $mov_id
            ]);

            return true;
            
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Transferência aceita interrompida, (saida). 402");
            return false;
        }
    }

    public function recusarTransferencia(int $mov_id)
    {
        try {
            $stmt =  $this->db->prepare("UPDATE tb_movimentacao SET mov_modo = :modo WHERE mov_id = :id");

            $stmt->execute([
                ':modo' => 'recusado',
                ':id' => $mov_id
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Transferência recusada interrompida, (saida). 402");
        }
    }

    public function buscarPendentes(int $id): array
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT * FROM tb_movimentacao WHERE mov_usuario_destino = :usuario AND mov_modo = :modo");
            $stmt->execute([
                ':usuario' => $id,
                ':modo' => 'pendente'
            ]);

            $this->db->commit();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Não foi possível acessar a caixa de entrada do usuário, (caixaEntrada). 402");
        }
    }
}
