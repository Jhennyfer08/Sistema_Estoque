<?php

require_once __DIR__ . '/../models/MaterialModel.php';

class MaterialController
{


    private $materialmodel;

    public function __construct(PDO $connection)
    {
        $this->materialmodel = new MaterialModel($connection);
    }

    public function create()
    {
        require_once __DIR__ . '/../views/cadastro/cadastroMaterial.php';
    }

    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                exit;
            }

            $dados = $this->dadosMaterial();

            $materiaExistente = $this->materialmodel->selectByCodigo($dados['codigo']);

            if ($materiaExistente) {
                $material_id = $materiaExistente['mat_id'];
            }

            $material_id = $this->materialmodel->insert([
                'codigo' => trim($_POST['mat_codigo']),
                'nome' => trim($_POST['mat_descricao']),
                'quantidade' => trim($_POST['mat_quantidade']),
                'valor' => $_POST['mat_valor'] ?? null,
                'status' => $_POST['mat_modo'],
                'uni_id' => $_POST['mat_unidadeMedida']
            ]);

            return $material_id;
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao cadastrar o material');
        }
    }

    private function list()
    {
        try {
            $materias = $this->materialmodel->selectAll();

            require_once __DIR__ . '/../views/cadastro/historicoMaterial.php';
        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            throw new Exception('Erro ao listar materiais (list). 403');
        }
    }



    private function dadosMaterial(): array
    {
        $dados = [
            'id' => $_POST['mat_id'] ?? null,
            'codigo' => trim($_POST['mat_codigo']),
            'nome' => trim($_POST['mat_descricao']),
            'quantidade' => trim($_POST['mat_quantidade']),
            'valor' => $_POST['mat_valor'] ?? null,
            'status' => $_POST['mat_modo'],
            'uni_id' => $_POST['mat_unidadeMedida']
        ];

        return $dados;
    }

    public function validarDados(array $dados): array
    {
        $erros = [];

        if (empty($dados['codigo'])) {
            $erros[] = 'Código inválido';
        }

        if (empty($dados['descricao']) || strlen($dados['descricao']) < 3) {
            $erros[] = 'nome do material precisa ter no mínimo 3 letras';
        }

        if (!preg_match('/^\[0-9]$/', $dados['valor'])) {
            $erros[] = 'Valor inválido. O campo é reservado para números';
        }

        if (!preg_match('/^\[0-9]$/', $dados['quantidade'])) {
            $erros[] = 'Quantidade inválida. O campo é reservado para números';
        }

        if (empty($dados['unidadeMedida'])) {
            $erros[] = 'Selecione uma unidade de medida';
        }

        if (empty($dados['modo'])) {
            $erros[] = 'Selecione um modo';
        }

        //Tabela Endereço

        if (!preg_match('/^\d{5}-?\d{3}$/', $dados['cep'])) {
            $erros[] = "CEP inválido";
        }

        if (empty($dados['rua'])) {
            $erros[] = "nome da Rua inválida";
        }

        if (!preg_match('/^\d+$/', $dados['numero'])) {
            $erros[] = "nome da Rua inválida";
        }

        if (empty($dados['bairro'])) {
            $erros[] = "Bairro inválido";
        }

        if (empty($dados['cidade'])) {
            $erros[] = "nome de cidade inválida";
        }

        if (empty($dados['estado'])) {
            $erros[] = "selecione um estado";
        }

        return $erros;
    }
}
