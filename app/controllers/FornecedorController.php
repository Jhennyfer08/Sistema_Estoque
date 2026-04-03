<?php

require_once __DIR__ . '/../models/FornecedorModel.php';
require_once __DIR__ . '/../models/EnderecoModel.php';

class FornecedorController
{
    private $fornecedormodel;
    private $enderecomodel;

    public function __construct(PDO $connection)
    {
        $this->fornecedormodel = new FornecedorModel($connection);
        $this->enderecomodel = new EnderecoModel($connection);
    }

    public function create(): void
    {
        require_once __DIR__ . '/../views/cadastro/cadastroFornecedor.php';
    }

    public function store()
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                exit;
            }

            $dados = $this->dadosFornecedor();

            $endereco_id = $this->enderecomodel->insert([
                'cep' => trim($_POST['end_cep']),
                'rua' => trim($_POST['end_rua']),
                'numero' => trim($_POST['end_numero']),
                'bairro' => trim($_POST['end_bairro']),
                'cidade' => trim($_POST['end_cidade']),
                'estado' => trim($_POST['end_estado']),
            ]);

            $fornecedorExistente = $this->fornecedormodel->selectByCnpj($dados['cnpj']);
            if ($fornecedorExistente) {
                $fornecedor_id = $fornecedorExistente['for_id'];
            }

            $fornecedor_id = $this->fornecedormodel->insert([
                'cnpj' => $dados['cnpj'],
                'nome' => $dados['nome'],
                'endereco_id' => $endereco_id
            ]);

            return $fornecedor_id;
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception("Erro ao cadastrar forncedor");
            exit;
        };
    }

    public function list()
    {
        try {
            $this->fornecedormodel->selectAll();

            require_once __DIR__ . "../views/historicoFornecedor.php";
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao listar os dados (list). 403');

            exit;
        }
    }

    public function edit($id)
    {
        try {
            $id = (int) $id;

            $fornecedor = $this->fornecedormodel->selectById($id);

            if (!$fornecedor) {
                exit('Fornecedor não encontrado. 404');
            }

            require_once __DIR__ . '../views/cadastro/editarFornecedor.php';
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao carregar edição (edit). 403');
        }
    }

    // public function update()
    // {
    //     try {
    //         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //             exit;
    //         }

    //         $dados = $this->dadosFornecedor();
    //         $errors = $this->validarDados($dados);

    //         $id = (int) $dados['id'];

    //         $fornecedor = $this->fornecedormodel->selectById($id);

    //         if (!$fornecedor) {
    //             exit("fornecedor não encontrado. 404");
    //         }

    //         $endereco_id = $fornecedor['end_id'];

    //         $this->enderecomodel->update([
    //             'cep' => $dados['cep'],
    //             'rua' => $dados['rua'],
    //             'numero' => $dados['numero'],
    //             'bairro' => $dados['bairro'],
    //             'cidade' => $dados['cidade'],
    //             'estado' => $dados['estado']
    //         ], $endereco_id);

    //         $this->fornecedormodel->update([
    //             'nome' => $dados['nome'],
    //             'cnpj' => $dados['cnpj']
    //         ], $id);
    //     } catch (\Exception $e) {
    //         error_log($e->getMessage(), $e->getCode());
    //         throw new Exception('Erro ao atualizar fornecedor (update). 403');
    //     }
    // }

    private function dadosFornecedor(): array
    {
        $dados = [
            'id' => $_POST['for_id'] ?? null,
            'nome' =>  trim($_POST['for_nome']),
            'cnpj' =>  trim($_POST['for_cnpj']),

            'cep' => trim($_POST['end_cep']),
            'rua' => trim($_POST['end_rua']),
            'numero' => trim($_POST['end_numero']),
            'bairro' => trim($_POST['end_bairro']),
            'cidade' => trim($_POST['end_cidade']),
            'estado' => trim($_POST['end_estado']),
        ];

        return $dados;
    }

    private function validarDados(array $dados): array
    {
        $erros = [];

        if (!preg_match('/^\d{14}$/', $dados['cnpj'])) {
            $erros[] = "CNPJ inválido";
        }

        if (empty($dados['nome']) || strlen($dados['nome']) < 3) {
            $erros[] = "Nome inválido";
        }

        if (!preg_match('/^\d{5}-?\d{3}$/', $dados['cep'])) {
            $erros[] = "CEP inválido";
        }

        if (empty($dados['rua'])) {
            $erros[] = "Rua inválida";
        }

        if (!preg_match('/^\d+$/', $dados['numero'])) {
            $erros[] = "Número inválido";
        }

        if (empty($dados['bairro'])) {
            $erros[] = "Bairro inválido";
        }

        if (empty($dados['cidade'])) {
            $erros[] = "Cidade inválida";
        }

        if (empty($dados['estado'])) {
            $erros[] = "Selecione um estado";
        }

        return $erros;
    }
}
