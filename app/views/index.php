<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/assets/css/config.css">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <!-- Fonts end -->
    <title>Login - Depósito</title>
</head>

<body>
    <header>

    </header>

    <main>
        <div class="container">
            <div class="logo">
                <img src="../../public/assets/img/logo/logo-g.png" alt="Logotipo da empresa Grangeiro Telecom">
                <img src="../../public/assets/img/logo/logotipo-grangeiro.png" alt="Logo completa da empresa Grangeiro Telecom">
            </div>

            <form action="/pages/home.php" method="post">
                <label for="input_login">Login</label>
                <input type="text" class="input-form" placeholder="Digite seu número de login" name="login" id="input_login" autocomplete="username" required>

                <label for="input_email">Email</label>
                <input type="email" class="input-form" placeholder="example@gmail.com" name="email" id="input_email" required>

                <label for="input_senha">Senha</label>
                <input type="password" class="input-form" placeholder="Digite a sua senha" id="input_senha" pattern="{4, 8}" autocomplete="current-password"
                    required>

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
                <button type="submit" class="submit-btn" id="submitButton" disabled>Entrar</button>
                <p id="errorMessage" class="message-btn">Captcha incorreto. Tente novamente </p>
            </form>
        </div>
    </main>
    <!-- 
    <script src="../../public/assets/js/index.js"></script> -->
</body>

</html>