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
                < Caixa de Entrada</a>
        </nav>
    </header>

    <main>
        <div class="container">

            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Remetente</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($caixa_materiais as $material): ?>
                        <tr>
                            <td><?= $material['mat_codigo'] ?></td>
                            <td><?= $material['mat_nome'] ?></td>
                            <td><?= $material['mov_quantidade'] ?></td>
                            <td><?= $material['remetente'] ?></td>
                            <td>
                                <a href="/estoque/public/material/aceitar"><img src="../../../public/assets/img/icons/accept.png" alt="botão de aceitar material"></a>
                                <a href="/estoque/public/material/recusar"><img src="../../../public/assets/img/icons/delete.png" alt="botão de recusar material"></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </main>
</body>

</html>