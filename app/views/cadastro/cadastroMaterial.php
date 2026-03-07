<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/assets/css/config.css">
    <link rel="stylesheet" href="../../../public/assets/css/cadastro.css">
    <title>Nome da empresa - Estoque</title>
</head>

<body>
    <header>
        <nav>
            <a href="cadastro.php">
                < Cadastro Material</a>
        </nav>
    </header>


    <main>
        <div class="container">
            <form action="#" method="POST" id="form">

                <div class="input-item" id="codigo">
                    <label for="input_codigo">Código:</label>
                    <input type="number" id="input_codigo" name="mat_codigo" required>
                    <span class="form-error"></span>
                </div>

                <section class="input-group">
                    <div class="input-item descricao" id="descricao">
                        <label for="input_descricao">Descricao:</label>
                        <input type="text" id="input_descricao" name="mat_descricao" required>
                        <span class="form-error"></span>
                    </div>
                    <div class="input-item valor" id="valor">
                        <label for="input_valor">Valor:</label>
                        <input type="number" id="input_valor" name="mat_valor" required>
                    </div>
                </section>

                <section class="input-group">
                    <div class="input-item" id="quantidade">
                        <label for="input_quantidade">Quantidade:</label>
                        <input type="number" id="input_quantidade" name="mat_quantidade" required>
                        <span class="form-error"></span>
                    </div>

                    <div class="input-item" id="unidade">
                        <label for="input_unidadeMedida">Unidade de Medida:</label>
                        <select id="input_unidadeMedida" name="mat_unidadeMedida" required>
                            <option value="" selected disabled>Selecione uma unidade</option>
                            <option value="unidade">Grama (UN)</option>
                            <option value="pacote">Pacote (PC)</option>
                            <option value="metro">Metro (M)</option>
                        </select>
                        <span class="form-error"></span>
                    </div>
                </section>

                <div class="input-item" id="status">
                    <label for="select_status">Status:</label>
                    <div class="select-menu" data-campo="status">
                        <select id="select_status" name="mat_status" required>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                        <span class="form-error"></span>
                    </div>
                </div>

                <div class="input-item" id="fornecedor">
                    <label for="select_fornecedor">Fornecedor:</label>
                    <div class="select-menu">
                        <select name="mat_fornecedor" id="select_fornecedor" required>
                            <option value="" selected disabled>Selecione um fornecedor</option>
                            <option value="fornecedor1">Fornecedor 1</option>
                            <option value="fornecedor2">Fornecedor 2</option>
                            <option value="fornecedor3">Fornecedor 3</option>
                        </select>

                        <input type="text" id="input_fornecedor" name="mat_novo_fornecedor" placeholder="Digite o nome do fornecedor">
                        <button class="toggle-btn">&#43</button>
                    </div>
                    <span class="form-error"></span>
                </div>

                <button type="submit" id="submitBtn" class="cadastro-btn">Cadastrar Material</button>
            </form>
        </div>
    </main>

    <script src="../../../public/assets/js/cadastroMaterial.js"></script>
</body>

</html>