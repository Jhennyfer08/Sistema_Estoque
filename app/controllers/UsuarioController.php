<?php

class UsuarioController
{
    private  $usuarioModel;
    private $funcaoModel;
    private  $setorModel;
    private  $enderecoModel;
    private  $logModel;
    private $movimentacaoModel;

    public function __construct(PDO $connection)
    {
        $this->usuarioModel = new UsuarioModel($connection);
        $this->funcaoModel = new FuncaoModel($connection);
        $this->setorModel = new SetorModel($connection);
        $this->enderecoModel = new EnderecoModel($connection);
        $this->logModel = new LogModel($connection);
        $this->movimentacaoModel = new MovimentacaoModel($connection);
    }

    public function create(): void
    {
        $setores = $this->setorModel->selectAll();
        $funcoes = $this->funcaoModel->selectAll();

        require_once __DIR__ . '/../views/cadastro/cadastroUsuario.php';
    }

    public function store()
    {
        try {
            $dados = $this->dadosUsuario();
            $erros = $this->validarDados($dados);

            $endereco_id = $this->enderecoModel->insert($_POST);

            if (!empty($_POST['novo_setor'])) {
                $setor_id = $this->setorModel->insert($_POST['novo_setor']);
            } else {
                $setor_id = $dados['setor_id'];
            }

            if (!empty($_POST['novo_funcao'])) {
                $funcao_id = $this->funcaoModel->insert($_POST['nova_funcao']);
            } else {
                $funcao_id = $dados['funcao_id'];
            }

            $this->usuarioModel->insert([
                ':matricula' => $dados['matricula'],
                ':cpf' => $dados['cpf'],
                ':nome' => $dados['nome'],
                ':data_nasc' => $dados['_nasc'],
                ':data_contrato' => $dados['data_contrato'],
                ':email' => $dados['email'],
                ':senha' => $dados['senha'],
                ':modo' => $dados['modo'],
                ':permissao' => $dados['permissao'],
                ':setor' => $setor_id,
                ':funcao' => $funcao_id,
                ':endereco' => $endereco_id
            ]);

        } catch (\Exception $e) {
            error_log($e->getMessage(), $e->getCode());
            exit;
        }
    }

    public function dadosUsuario(): array
    {

        $dados = [
            'matricula' => trim($_POST['usu_n_matricula']),
            'cpf' => trim($_POST['usu_cpf']),
            'nome' => trim($_POST['usu_nome']),
            'data_nasc' => trim($_POST['usu_data_nasc']),
            'data_contrato' => trim($_POST['usu_data_contrato']),
            'email' => trim($_POST['usu_email']),
            'senha' => trim($_POST['usu_senha']),
            'modo' => trim($_POST['usu_modo']),
            'permissao' => trim($_POST['usu_permissao']),

            //FK´s
            'setor_id' => trim($_POST['usu_setor']),
            'novo_setor' => trim($_POST['usu_novo_setor'] ?? null),

            'funcao_id' => trim($_POST['usu_funcao']),
            'nova_funcao' => trim($_POST['usu_nova_funcao'] ?? null),


            //Endereço
            'cep' => trim($_POST['end_cep']),
            'rua' => trim($_POST['end_rua']),
            'numero' => trim($_POST['end_numero']),
            'bairro' => trim($_POST['end_bairro']),
            'cidade' => trim($_POST['end_cidade']),
            'estado' => trim($_POST['end_estado']),
        ];

        return $dados;
    }

    public function validarDados(array $dados): array
    {
        $erros = [];

        if (!preg_match('/^\d{8}$/', $dados['matricula'])) {
            $erros[] = "Código de matrícula inválido. É preciso ter 8 números";
        }

        if (!preg_match('/^\d{11}$/', $dados['cpf'])) {
            $erros[] = "CPF Inválido";
        }

        if (empty($dados['nome']) || strlen($dados['nome']) < 3) {
            $erros[] = "O nome do usuário é obrigatório";
        }

        if (empty($dados['data_nasc'])) {
            $erros[] = "Data de nascimento inválida";
        }

        if (empty($dados['data_contrato'])) {
            $erros[] = "Data de contrato inválida";
        }

        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $erros[] = "Email inválido";
        }

        if (!preg_match('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})$/', $dados['senha'])) { //Colocar o obrigatório de 8 caracteres, uma letra maiúscula e uma número
            $erros[] = "Senha incompleta";
        }

        if (empty($dados['modo'])) {
            $erros[] = "Selecione um modo";
        }

        //Tabelas Setor e Função

        if (empty($dados['setor'])) {
            $erros[] = "Selecione pelo menos um setor";
        }

        if (empty($dados['funcao'])) {
            $erros[] = "Selecione pelo menos uma funcao";
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
