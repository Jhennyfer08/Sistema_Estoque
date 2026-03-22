<?php

class MovimentacaoModel
{
    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }

    public function registrarMovimentacao($tipo, $dados): int
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO tb_movimentacao(mov_tipo, mov_quantidade, mov_data, mov_status, tb_material_mat_id, tb_usuario_usu_id, mov_usuario_destino)
            VALUES (:tipo, :qtd, NOW(), 'pendente', :material, :remetente, :destinatario)");

            $stmt->execute([
                ':tipo' => $tipo,
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
            throw new Exception("registro da movimentação não realizada (registrarMovimentacao). 402");
        }
    }

    public function listarMovimentacao($usu_id, $tipo): array
    {
        try {
            $stmt = $this->db->prepare("SELECT m.*, mat.mat_nome, u.usu_nome AS remetente
            FROM tb_movimentacao m 
            JOIN tb_material mat ON mat.mat_id = m.tb_material_mat_id
            JOIN tb_usuario u ON u.usu_id = m.tb_usuario_usu_id
            WHERE m.mov_usuario_destino = :usu_id
            AND m.mov_tipo = :mov_tipo");

            $stmt->execute([
                ':usu_id' => $usu_id,
                ':mov_tipo' => $tipo
            ]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("listagem da movimentação não realizada (registrarTransferencia). 402");
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
            throw new Exception("aceitar transferência interrompida, (aceitarTransferencia). 402");
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
            throw new Exception("recusar transferência interrompida, (recusarTransferencia). 402");
        }
    }

    public function buscarPendentes(int $id): array
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT m.*, mat.mat_nome, u.usu_nome AS remetente
            FROM tb_movimentacao m 
            JOIN tb_material mat ON mat.mat_id = m.tb_material_mat_id
            JOIN tb_usuario u ON u.usu_id = m.tb_usuario_usu_id
            WHERE m.mov_usuario_destino = :destinatario
            AND m.mov_modo = :modo");

            $stmt->execute([
                ':destinatario' => $id,
                ':modo' => 'pendente'
            ]);

            $this->db->commit();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Não foi possível acessar a caixa de entrada do usuário, (buscarPendentes). 402");
        }
    }
}
