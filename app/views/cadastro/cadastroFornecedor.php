<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/assets/css/config.css">
    <link rel="stylesheet" href="../../public/assets/css/cadastro.css">
    <title>Grangeiro Telecom - Estoque</title>
</head>

<body>
    <header>
        <nav>
            <a href="cadastroMaterial.php">
                < Cadastro Fornecedor</a>
        </nav>
    </header>

    <main>
        <div class="container">
            <form action="" method="POST" id="form">

                <section class="input-group">
                    <div class="input-item" id="nome">
                        <label for="input-nome">Nome</label>
                        <input type="text" id="input-nome" name="end_nome">
                        <span class="form-error"></span>
                    </div>

                    <div class="input-item" id="cnpj">
                        <label for="input-cnpj">CNPJ</label>
                        <input type="number" id="input-cnpj" name="end_cnpj" placeholder="000.000/0000-00">
                        <span class="form-error"></span>
                    </div>
                </section>

                <div class="input-item" id="cep">
                    <label for="input-cep">CEP</label>
                    <input type="number" id="input-cep" name="end_cep" placeholder="00000-000">
                    <span class="form-error"></span>
                </div>

                <section class="input-group">
                    <div class="input-item" id="rua">
                        <label for="input-rua">Rua</label>
                        <input type="text" id="input-rua" name="end_rua">
                        <span class="form-error"></span>
                    </div>
                    <div class="input-item" id="numero">
                        <label for="input-numero">Número</label>
                        <input type="number" id="input-numero" name="end_numero">
                        <span class="form-error"></span>
                    </div>
                </section>

                <div class="input-item" id="bairro">
                    <label for="input-bairro">Bairro</label>
                    <input type="text" id="input-bairro" name="end_bairro">
                    <span class="form-error"></span>
                </div>

                <section class="input-group">
                    <div class="input-item" id="cidade">
                        <label for="input-cidade">Cidade</label>
                        <input type="text" id="input-cidade" name="end_cidade">
                        <span class="form-error"></span>
                    </div>
                    <div class="input-item" id="estado">
                        <label for="select-estado">Estado</label>
                        <select name="end_estado" id="select-estado"></select>
                        <span class="form-error"></span>
                    </div>
                </section>

                <button type="submit" id="submitBtn" class="cadastro-btn">Cadastrar Fornecedor</button>
            </form>
        </div>
    </main>

    <script src="../../public/assets/js/cadastroFornecedor.js"></script>
</body>

</html>