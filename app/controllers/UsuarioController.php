<?php
require_once __DIR__ . '/../models/UsuarioModel.php';
require_once __DIR__ . '/../models/FuncaoModel.php';
require_once __DIR__ . '/../models/SetorModel.php';
require_once __DIR__ . '/../models/EnderecoModel.php';
require_once __DIR__ . '/../models/LogModel.php';
require_once __DIR__ . '/../models/MovimentacaoModel.php';

class UsuarioController
{
    private $auth;
    private $usuarioModel;
    private $funcaoModel;
    private  $setorModel;
    private  $enderecoModel;
    private  $logModel;
    private $movimentacaoModel;

    public function __construct(PDO $connection)
    {
        $this->auth = new Auth();
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
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                exit;
            }

            $usuario = $this->auth->user();
            $dados = $this->dadosUsuario();

            //FK´s | ENDEREÇO | SETOR | FUNÇÃO
            $endereco_id = $this->enderecoModel->insert($dados);

            $setor_id = null;

            if (!empty($dados['novo_setor'])) {
                $setorExistente = $this->setorModel->selectByName($dados['novo_setor']);

                if ($setorExistente) {
                    $setor_id = $setorExistente['set_id'];
                } else {
                    $setor_id = $this->setorModel->insert($dados['novo_setor']);
                }
            } else {
                $setor_id = $dados['setor_id'];
            }

            $funcao_id = null;

            if (!empty($dados['nova_funcao'])) {
                $funcaoExistente = $this->funcaoModel->selectByName($dados['nova_funcao']);

                if ($funcaoExistente) {
                    $funcao_id = $funcaoExistente['fun_id'];
                } else {
                    $funcao_id = $this->funcaoModel->insert($dados['nova_funcao']);
                }
            } else {
                $funcao_id = $dados['funcao_id'];
            }

            //Autorização do almoxarifado
            $almoxarifado = $this->setorModel->selectByName('Almoxarifado');

            $permissao = 'F';

            if ($almoxarifado && $usuario['permissao'] == $almoxarifado['set_id']) {
                $permissao = 'A';
            } else {
                $permissao = 'F';
            }

            //C LOGIN FUNCIONANDO
            // $permissao = $_SESSION['usuario_permissao'];

            $this->usuarioModel->insert([
                'matricula' => $dados['matricula'],
                'cpf' => $dados['cpf'],
                'nome' => $dados['nome'],
                'data_nasc' => $dados['data_nasc'],
                'data_contrato' => $dados['data_contrato'],
                'email' => $dados['email'],
                'senha' => $dados['senha'],
                'modo' => $dados['modo'],
                'permissao' => $permissao,
                'endereco_id' => $endereco_id,
                'setor_id' => $setor_id,
                'funcao_id' => $funcao_id
            ]);

            header('Location: /estoque/public/usuario/listar');
        } catch (\Exception $e) {
            error_log($e->getMessage());
            exit;
        }
    }
    
    public function list()
    {
        try {
            $usuarios = $this->usuarioModel->selectAll();
            require_once __DIR__ . '/../views/cadastro/historicoUsuario.php';
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception('Erro ao listar os dados (list). 403');
        }
    }

    public function edit($id)
    {
        try {
            $id = htmlspecialchars($_GET['id']);

            if (!$id) {
                exit('Id não informado!. 403');
            }

            $usuario = $this->usuarioModel->selectById($id);

            if (!$usuario) {
                http_response_code(404);
                exit('Usuário não encontrado. 403');
            }

            require_once __DIR__ . '';
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception('Erro ao editar os dados (edit). 403');
        }
    }

    public function update($id)
    {
        try {
            $dados = $this->dadosUsuario();
            $erros = $this->validarDados($dados);

            $id = htmlspecialchars($_GET['id']);
            $this->usuarioModel->update($dados, $id);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new Exception('Erro ao atualizar os dados (update). 403');
        }
    }


    public function delete($id)
    {
        $id = htmlspecialchars($_GET['id']);

        $this->usuarioModel->delete($id);
    }

    //PÁGINAS DO SITE

    public function cadastro(){
        require_once __DIR__.'/../views/cadastro/cadastro.php';
    }

    //AQUISIÇÃO E VALIDAÇÃO DE DADOS DO FORMULÁRIO DE CADASTRO DE USUÁRIO
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

        if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $dados['senha'])) { //Colocar o obrigatório de 8 caracteres, uma letra maiúscula e um número
            $erros[] = "Senha inválida";
        }

        if (empty($dados['modo'])) {
            $erros[] = "Selecione um status";
        }

        //Tabelas Setor e Função

        if (empty($dados['setor_id'])) {
            $erros[] = "Selecione pelo menos um setor";
        }

        if (empty($dados['funcao_id'])) {
            $erros[] = "Selecione pelo menos uma funcao";
        }

        //Tabela Endereço

        if (!preg_match('/^\d{5}-?\d{3}$/', $dados['cep'])) {
            $erros[] = "CEP inválido";
        }

        if (empty($dados['rua'])) {
            $erros[] = "Insira um nome da Rua";
        }

        if (!preg_match('/^\d+$/', $dados['numero'])) {
            $erros[] = "Insira um número";
        }

        if (empty($dados['bairro'])) {
            $erros[] = "Insira um bairro";
        }

        if (empty($dados['cidade'])) {
            $erros[] = "Insira um nome de cidade";
        }

        if (empty($dados['estado'])) {
            $erros[] = "Selecione um estado";
        }

        return $erros;
    }
}
