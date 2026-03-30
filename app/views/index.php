<?php

require_once __DIR__ . '/../../core/Auth.php';

$auth = new Auth();
$erro = $auth->showFlash('erro_login');
$old_info = $auth->showFlash('old_info') ?? [];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/config.css">
    <link rel="stylesheet" href="../public/assets/css/login.css">
    <title>Login - Depósito</title>
</head>

<body>
    <header>

    </header>

    <main>
        <div class="container">
            <div class="logo">
                <img src="../public/assets/img/logo/logo-g.png" alt="Logotipo da empresa Grangeiro Telecom">
                <img src="../public/assets/img/logo/logotipo-grangeiro.png" alt="Logo completa da empresa Grangeiro Telecom">
            </div>

            <form action="/estoque/public/auth/login" method="POST">

                <p id="errorMessage" class="message-btn"> </p>

                <div class="input-item" id="login">
                    <label for="input_login">Login</label>
                    <input type="text" class="input-form" name="usu_login" id="input_login" placeholder="Digite seu número de login" required>
                </div>

                <div class="input-item" id="email">
                    <label for="input_email">Email</label>
                    <input type="email" class="input-form" name="usu_email" id="input_email" placeholder="example@gmail.com" autocomplete="email" required>
                </div>

                <div class="input-item" id="senha">
                    <label for="input_senha">Senha</label>
                    <input type="password" class="input-form" name="usu_senha" id="input_senha" placeholder="Digite a sua senha" pattern="{4, 8}" autocomplete="current-password" required>
                </div>

                <!-- <div class="captchaImg-container">
                    <img src="" alt="Imagem CAPTCHA" id="captchaImage">

                    <button type="button" class="refresh-btn" id="refreshButton">
                        <img src="../../public/assets/img/icons/refreshIcon.png" alt="Atualizar">
                    </button>
                </div>

                <label for="captchaInput">Digite o código a baixo: </label>
                <input type="text" class="input-form" id="captchaInput" name="captchaId" required>
                -->
                <a href="#" id="recuperacaoSenha">Esqueceu sua senha? Clique aqui</a>
                <button type="submit" class="submit-btn" id="submitButton">Entrar</button>

                <div id="flash-message"
                    data-message="<?= htmlspecialchars($erro ?? '') ?>"
                    data-type="error"

                    data-login="<?= htmlspecialchars($old_info['login'] ?? '') ?>"
                    data-email="<?= htmlspecialchars($old_info['email'] ?? '') ?>">
                </div>

            </form>

        </div>
    </main>

    <script src="../public/assets/js/login.js"></script>
</body>

</html>