<?php
require_once __DIR__ . '/../models/MovimentacaoModel.php';
require_once __DIR__ . '/../models/EstoqueModel.php';

class MovimentacaoController
{
    private $movimentacaoModel;
    private $estoqueModel;

    public function __construct(PDO $connection)
    {
        $this->movimentacaoModel = new MovimentacaoModel($connection);
        $this->estoqueModel = new EstoqueModel($connection);
    }

    public function transferencia()
    {
        try {
            $dados = $this->dadosMovimentacao();
            $erros = $this->validarDados($dados);

        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception('Erro ao transferir os materiais (transferencia). 403');
        }
    }

    public function dadosMovimentacao(): array
    {
        $dados = [
            'remetente_id' => $_SESSION['usu_id'],
            'destinatario_id' => trim($_POST['destinatario_id']),
            'material_id' => trim($_POST['material_id']),
            'quantidade' => trim($_POST['quantidade']),
        ];

        return $dados;
    }

    public function validarDados(array $dados): array
    {
        $erros = [];

        if (empty($dados["remetente_id"])) {
            $erros[] = 'Campo do remetente vazio';
        }

        if (empty($dados["destinatario_id"])) {
            $erros[] = 'Campo do destinatario vazio';
        }

        if (empty('material_id')) {
            $erros[] = 'Campo do material vazio';
        }

        if (empty($dados['quantidade'])) {
            $erros[] = 'Campo da quantidade vazio';
        }

        return $erros;
    }
}
