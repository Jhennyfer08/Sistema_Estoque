<?php

class MaterialController
{
    protected $materialModel;

    public function __construct(PDO $connection)
    {
        $this->materialModel = $connection;
    }

    public function dadosMaterial(): array
    {

        $dados = [
            'codigo' => $_POST['mat_codigo'],
            'descricao' => $_POST['mat_descricao'],
            'valor' => $_POST['mat_valor'],
            'quantidade' => $_POST['mat_quantidade'],
            'unidadeMedida' => $_POST['mat_unidadeMedida'],
            'modo' => $_POST['mat_modo'],
            'fornecedor' => $_POST['mat_fornecedor'],
            'cep' => $_POST['end_cep'] ?? null,
            'rua' => $_POST['end_rua'] ?? null,
            'numero' => $_POST['end_numero'] ?? null,
            'bairro' => $_POST['end_bairro'] ?? null,
            'cidade' => $_POST['end_cidade'] ?? null,
            'estado' => $_POST['end_estado'] ?? null
        ];

        return $dados;
    }

    public function validarDados(array $dados): array{
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
