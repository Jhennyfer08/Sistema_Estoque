<?php
require_once __DIR__ . '/../../../core/Auth.php';
$auth = new Auth();
$usuario = $auth->user();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/config.css">
    <link rel="stylesheet" href="../public/assets/css/selecao.css">
    <title>Nome da empresa - Estoque</title>
</head>

<body>

    <header>
        <nav>
            <div class="logo">
                <img src="../public/assets/img/logo/logo-g-branca.png" alt="">
            </div>
            <a href="../index.php">Voltar</a>
        </nav>

    </header>

    <main>
        <div class="container">
            <!-- Caixa de estoque -->
            <section>
                <a href="caixaEntrada.php">
                    <div class="img-container">
                        <img src="../public/assets/img/ilustracoes/caixa_de_entrada.png" alt="Imagem ilustrativa sobre a página">
                    </div>
                    <h2>Caixa de Entrada</h2>
                </a>
            </section>

            <!-- Retorno de material -->
            <section>
                <a href="retorno.php">
                    <div class="img-container">
                        <img src="../public/assets/img/ilustracoes/retornar.png" alt="Imagem ilustrativa sobre a página">
                    </div>
                    <h2>Retorno de Material</h2>
                </a>
            </section>

            <!-- Tranferências -->
            <section>
                <a href="transferencia.php">
                    <div class="img-container">
                        <img src="../public/assets/img/ilustracoes/tranferencia.png" alt="Imagem ilustrativa sobre a página">
                    </div>
                    <h2>Transferências</h2>
                </a>
            </section>

            <!-- Caixa total -->
            <section>
                <a href="caixaTotal.php">
                    <div class="img-container">
                        <img src="../public/assets/img/ilustracoes/caixa_total.png" alt="Imagem ilustrativa sobre a página">
                    </div>
                    <h2>Caixa Total</h2>
                </a>
            </section>

            <!-- Contingência -->
            <section>
                <a href="contigencia.php">
                    <div class="img-container">
                        <img src="../public/assets/img/ilustracoes/contigencia.png" alt="Imagem ilustrativa sobre a página">
                    </div>
                    <h2>Contigência</h2>
                </a>
            </section>

            <!-- Cadastro -->
            <?php if ($usuario['permissao'] == 'A'): ?>
                <section>
                    <a href="/estoque/public/cadastro">
                        <div class="img-container">
                            <img src="../public/assets/img/ilustracoes/cadastro.png" alt="Imagem ilustrativa sobre a página">
                        </div>
                        <h2>Cadastro</h2>
                    </a>
                </section>
            <?php endif; ?>
        </div>
    </main>

    <footer>

    </footer>
</body>

</html>