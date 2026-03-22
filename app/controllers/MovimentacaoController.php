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

    public function caixaEntrada()
    {
        try {
            $dados = $this->dadosMovimentacao();
            $erros = $this->validarDados($dados);

            $usuarioId = $_SESSION['usuario_id'];

            $caixa_materiais = $this->movimentacaoModel->buscarPendentes($usuarioId);
            require_once __DIR__ . '/../views/home/caixaEntrada.php';
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception('Erro ao transferir os materiais (caixaEntrada). 403');
        }
    }

    public function transferencia()
    {
        try {
            $dados = $this->dadosMovimentacao();
            $erros = $this->validarDados($dados);

            $usuarioId = $_SESSION['usuario_id'];
            $transferencias = $this->movimentacaoModel->listarMovimentacao($usuarioId, 'transferencia');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception('Erro ao transferir os materiais (caixaEntrada). 403');
        }
    }

    public function realizarTransferencia()
    {
        try {
            $dados = $this->dadosMovimentacao();
            $erros = $this->validarDados($dados);

            if ($dados['remetente_id'] == $dados['destinatario_id']) {
                throw new Exception('Usuário remetente não pode ser igual ao usuário destinatário. 403');
            }

            $this->movimentacaoModel->registrarMovimentacao('transferencia', $dados);

            $this->estoqueModel->retirarEstoque($dados['quantidade_id'], $dados['remetente_id'], $dados['material_id']);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception('Erro ao transferir os materiais (realizarTransferencia). 403');
        }
    }

    public function aceitarTransferencia()
    {
        try {
            $dados = $this->dadosMovimentacao();
            $erros = $this->validarDados($dados);

            $usuarioId = $_SESSION['usuario_id'];
            $transferencia =  $this->movimentacaoModel->buscarPendentes($usuarioId);

            $this->movimentacaoModel->aceitarTransferencia($transferencia['mov_id']) == true;
            $this->estoqueModel->adicionarEstoque($transferencia['mov_quantidade'], $transferencia['mov_usuario_destino'], $transferencia['tb_material_mat_id']);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception('Erro ao aceitar os materiais (receberTransferencia). 403');
        }
    }

    public function recusarTransferencia()
    {
        try {
            $dados = $this->dadosMovimentacao();
            $erros = $this->validarDados($dados);

            $usuarioId = $_SESSION['usuario_id'];
            $transferencia =  $this->movimentacaoModel->buscarPendentes($usuarioId);

            $this->estoqueModel->voltarEstoque($transferencia['mov_quantidade'], $transferencia['tb_usuario_usu_id'], $transferencia['tb_material_mat_id']);
            $this->movimentacaoModel->recusarTransferencia($transferencia['mov_id']);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception('Erro ao aceitar os materiais (receberTransferencia). 403');
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
