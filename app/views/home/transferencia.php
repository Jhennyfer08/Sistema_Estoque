<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/assets/css/config.css">
    <link rel="stylesheet" href="../../../public/assets/css/caixaTotal.css">
    <title>Nome da empresa - Estoque</title>
</head>

<body>

    <header>
        <nav>
            <a href="home.php">
                < Transferências</a>
        </nav>
    </header>

    <main>
        <div class="container">
            <nav class="nav-bar">
                <p id="lista">Histórico de Tranferências</p>
                <p id="container">Realizar Transferência</p>
                <span></span>
            </nav>

            <div id="listaTable">
                <table>
                    <thead>
                        <tr>
                            <th>Remetente</th>
                            <th>Material</th>
                            <th>Quantidade</th>
                            <th>Destinatário</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($transferencias as $transferencia): ?>
                            <tr>
                                <td><?= $transferencia['remetente'] ?></td>
                                <td><?= $transferencia['mat_nome'] ?></td>
                                <td><?= $transferencia['mov_quantidade'] ?></td>
                                <td><?= $transferencia['mov_usuario_destino'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

                <!--  -->
            </div>

            <div id="containerSecao">

                <div class="menu-selecao">
                    <p id="aviso"> Selecione os materiais a serem retornados </p>
                    <p id="selecionar-todos">Selecionar todos</p>
                </div>

                <table id="material">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>...</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($transferencias as $transferencia): ?>
                            <tr>
                                <td><?= $transferencia['remetente'] ?></td>
                                <td><?= $transferencia['mat_nome'] ?></td>
                                <td><?= $transferencia['mov_quantidade'] ?></td>
                                <td><?= $transferencia['mov_usuario_destino'] ?></td>
                                <td><input type="checkbox" name="selecionarCheckbox" class="checkbox"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <button type="submit" id="buttonConfirmar" onclick="PesquisarId()">Confirmar Transferência</button>
            </div>
        </div>
    </main>


    <script src="../../../public/assets/js/display.js"></script>
</body>

</html>