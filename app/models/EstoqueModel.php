<?php
class EstoqueModel
{
    private $db;

    public function __construct(PDO $connection)
    {
        $this->db = $connection;
    }

    public function retirarEstoque($qtd, $remetente_id, $material_id)
    {
        try {
            $this->db->beginTransaction();

            //RETIRA O MATERIAL DO ESTOQUE DO REMETENTE 
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

    public function adicionarEstoque($qtd, $destinatario_id, $material_id)
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

    public function voltarEstoque($qtd, $remetente_id, $material_id)
    {
        try {
            $this->db->beginTransaction();

            //DEVOLVE O MATERIAL PARA O REMETENTE
            $stmt = $this->db->prepare("UPDATE tb_estoque SET est_quantidade = est_quantidade + :qtd
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
}
