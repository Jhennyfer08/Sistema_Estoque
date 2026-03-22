<?php

class EstoqueModel
{
    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }

    public function transferencia(array $dados)
    {
        try {
            $this->db->beginTransaction();

            //SELECIONA A QUANTIDADE DE MATERIAL À SER TRANSFERIDO
            $stmt = $this->db->prepare("SELECT est_quantidade FROM tb_estoque
            WHERE tb_usuario_usu_id = :usuario AND tb_material_mat_id = :material");

            $stmt->execute([
                ':usuario' => $dados['remetente_id'],
                ':material' => $dados['material_id']
            ]);
            $estoque = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$estoque || $estoque['est_quantidade'] < $dados['quantidade']) {
                throw new Exception("Não há material suficiente.(402)");
            }

            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Tranferência não realizada (transferencia). 402");
        }
    }

    public function retirarEstoque($qtd, $remetente_id, $material_id)
    {
        try {
            $this->db->beginTransaction();

            //ATUALIZA A RETIRADA DO MATERIAL DO ESTOQUE DO REMETENTE 
            $stmt = $this->db->prepare("UPDATE tb_estoque SET est_quantidade = est_quantidade - :qtd
            WHERE tb_usuario_usu_id = :usuario AND tb_material_mat_id = :material");

            $stmt->execute([
                ':qtd' => $qtd,
                ':usuario' => $remetente_id,
                ':material' => $material_id
            ]);

            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Tranferência não realizada (transferencia). 402");
        }
    }

    public function receberTransferencia($qtd, $destinatario_id, $material_id)
    {
        try {
            $this->db->beginTransaction();

            //INSERE O MATERIAL NO ESTOQUE DO DESTINATÁRIO
            $stmt = $this->db->prepare("INSERT INTO tb_estoque(est_quantidade, tb_usuario_usu_id, tb_material_mat_usu_id) 
            VALUES (:qtd, :usuario, :material) ON DUPLICATE KEY UPDATE est_quantidade = est_quantidade + :qtd");
            $stmt->execute([
                ':qtd' => $qtd,
                ':usuario' => $destinatario_id,
                ':material' => $material_id
            ]);

            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Tranferência não realizada (transferencia). 402");
        }
    }

    public function recusarTransferencia(array $dados)
    {
        try {
            $this->db->beginTransaction();

            //INSERE O MATERIAL NO ESTOQUE DO DESTINATÁRIO
            $stmt = $this->db->prepare("INSERT INTO tb_estoque(est_quantidade, tb_usuario_usu_id, tb_material_mat_usu_id) 
            VALUES (:qtd, :usuario, :material) ON DUPLICATE KEY UPDATE est_quantidade = est_quantidade + :qtd");
            $stmt->execute([
                ':qtd' => $dados['quantidade'],
                ':usuario' => $dados['destinatario_id'],
                ':material' => $dados['material_id']
            ]);

            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Tranferência não realizada (transferencia). 402");
        }
    }
}
