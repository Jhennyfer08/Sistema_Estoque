<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/assets/css/config.css">
    <link rel="stylesheet" href="../../public/assets/css/cadastro.css">
    <title>Nome da empresa - Estoque</title>
</head>

<body>
    <header>
        <nav>
            <a href="cadastro.php">
                < Cadastro Usuário</a>
        </nav>
    </header>

    <main>
        <div class="container">

            <form action="/estoque/public/cadastro/usuario/enviar" method="POST" id="form">

                <section class="input-group-number">
                    <div class="input-item" id="matricula">
                        <label for="input_n_matricula">Número de Matrícula:</label>
                        <input type="number" id="input_n_matricula" name="usu_n_matricula" maxlength="8"
                            pattern="\d{8}" placeholder="00000000" required>
                        <span class="form-error"></span>
                        <!-- Coloquei máximo de caracter aqui -->
                    </div>

                    <div class="input-item" id="cpf">
                        <label for="input_cpf">CPF:</label>
                        <input type="number" name="usu_cpf" maxlength="11" id="input_cpf" pattern="\d{11}" placeholder="000.000.000-00"
                        required>
                        <span class="form-error"></span>
                    </div>

                </section>

                <div class="input-item" id="nome">
                    <label for="input_nome">Nome Completo:</label>
                    <input type="text" id="input_nome" name="usu_nome" required>
                    <span class="form-error"></span>
                </div>

                <section class="input-group-date">

                    <div class="input-item" id="nasc">
                        <label for="input_data_nasc">Data de Nascimento:</label>
                        <input type="date" id="input_data_nasc" name="usu_data_nasc" required>
                        <span class="form-error"></span>
                    </div>

                    <div class="input-item" id="contrato">
                        <label for="input_data_contrato">Data de Contratação:</label>
                        <input type="date" id="input_data_contrato" name="usu_data_contrato" required>
                        <span class="form-error"></span>
                    </div>
                </section>

                <div class="input-item" id="email">
                    <label for="input_email">Email:</label>
                    <input type="email" id="input_email" name="usu_email" autocomplete="email" placeholder="example@gmail.com" required>
                    <span class="form-error"></span>
                </div>

                <div class="input-item" id="senha">
                    <label for="input_senha">Senha:</label>
                    <input type="password" id="input_senha" name="usu_senha" autocomplete="current-password" required>
                    <span class="form-error"></span>
                </div>

                <div class="input-item" id="setor">
                    <label for="select_setor">Setor:</label>
                    <div class="select-menu" data-campo="setor">
                        <select id="select_setor" name="usu_setor" required>
                            <option value="" selected disabled>Selecione um setor</option>
                            <?php foreach ($setores as $setor): ?>
                                <option value="<?= $setor['set_id'] ?>"> <?= $setor['set_nome'] ?> </option>
                            <?php endforeach; ?>
                            <!-- <option value="Tecnico">Técnico</option>
                            <option value="Administrativo">Administrativo</option>
                            <option value="Almoxarifado">Almoxarifado</option>
                            <option value="Gerencia">Gerência</option>
                            <option value="Diretoria">Diretoria</option>
                            <option value="Presidente">Presidente</option> -->
                        </select>

                        <input type="text" id="input_setor" name="usu_novo_setor" placeholder="Digite o nome do setor">
                        <button type="button" class="toggle-btn">&#43</button>
                    </div>
                    <span class="form-error"></span>
                </div>

                <div class="input-item" id="funcao">
                    <label for="select_funcao">Função:</label>
                    <div class="select-menu" data-campo="funcao">
                        <select id="select_funcao" name="usu_funcao" required>
                            <option value="" selected disabled>Selecione uma função</option>
                            <?php foreach ($funcoes as $funcao): ?>
                                <option value="<?= $funcao['fun_id'] ?>"><?= $funcao['fun_nome'] ?></option>
                            <?php endforeach; ?>
                            <option value="AuxiliarAdministrativo">Auxiliar Administrativo</option>
                            <option value="Supervisor">Supervisor</option>
                        </select>

                        <input type="text" id="input_funcao" name="usu_nova_funcao" placeholder="Digite o nome da função">
                        <button type="button" class="toggle-btn">&#43</button>
                    </div>
                    <span class="form-error"></span>
                </div>

                <div class="input-item" id="modo">
                    <label for="select_modo">Status:</label>
                    <div class="select-menu" data-campo="modo">
                        <select id="select_modo" name="usu_modo" required>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>
                    </div>
                </div>

                <div class="input-item" id="cep">
                    <label for="input-cep">CEP</label>
                    <input type="number" id="input-cep" name="end_cep" placeholder="00000-000">
                </div>


                <section class="input-group">
                    <div class="input-item" id="rua">
                        <label for="input-rua">Rua</label>
                        <input type="text" id="input-rua" name="end_rua" required>
                    </div>
                    <div class="input-item" id="numero">
                        <label for="input_numero">Número</label>
                        <input type="number" id="input_numero" name="end_numero" required>
                    </div>
                </section>

                <div class="input-item" id="bairro">
                    <label for="input_bairro">Bairro</label>
                    <input type="text" id="input_bairro" name="end_bairro" required>
                </div>

                <section class="input-group">
                    <div class="input-item" id="cidade">
                        <label for="input_cidade">Cidade</label>
                        <input type="text" id="input_cidade" name="end_cidade" required>
                    </div>
                    <div class="input-item" id="estado">
                        <label for="select-estado">Estado</label>
                        <select name="end_estado" id="select-estado" required></select>
                    </div>
                </section>

                <button type="submit" class="cadastro-btn" id="submitBtn">Cadastrar</button>
            </form>
        </div>
    </main>

    <script src="../../public/assets/js/cadastroUsuario.js"></script>
</body>

</html>