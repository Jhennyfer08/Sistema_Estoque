<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/assets/css/config.css">
    <link rel="stylesheet" href="../../public/assets/css/cssRetorno/historicoRetorno.css">
    <title>Nome da empresa - Estoque</title>
</head>

<body>
    <header>
        <nav>
            <a href="retorno.php">
                < Histórico de Usuario</a>
        </nav>
    </header>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Data Nascimento</th>
                    <th>Data Contrato</th>
                    <th>Status</th>
                    <th>Permissão</th>
                    <th>Setor</th>
                    <th>Função</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['usu_id'] ?></td>
                        <td><?= $usuario['usu_codigo'] ?></td>
                        <td><?= $usuario['usu_cpf'] ?></td>
                        <td><?= $usuario['usu_nome'] ?></td>
                        <td><?= $usuario['usu_data_nasc'] ?></td>
                        <td><?= $usuario['usu_data_cont'] ?></td>
                        <td><?= $usuario['usu_email'] ?></td>
                        <td><?= $usuario['usu_status'] ?></td>
                        <td><?= $usuario['usu_permissao'] ?></td>
                        <td><?= $usuario['set_nome'] ?></td>
                        <td><?= $usuario['fun_nome'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>