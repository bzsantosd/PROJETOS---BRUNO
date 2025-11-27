<?php
// View/auth/login.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechFit Academia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8a2be2; /* Um tom de roxo vibrante */
            --text-color: #ffffff;
            --dark-bg: #000000;
            --input-bg: #ffffff;
            --link-color: #8a2be2; /* Roxo mais claro para links */
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html, body {
            height: 100%;
            background-color: #ffffff;
        }

        .login-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }
        .image-section {
            flex: 1;
            background-color: #222; 
            background-image: url('/IMAGENS/07.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
            padding: 20px;
            color: var(--text-color);
        }
        .login-section {
            flex: 1;
            background-color: var(--dark-bg);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 80%;
            max-width: 350px;
            text-align: center;
        }

        .login-title {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .background-image {
            width: 90px; 
            height: 90px; 
            object-fit: contain;
            display: block;
            margin: 0 auto 40px auto; /* Aumentei o margin-bottom para 40px */
        }
        .login-form {
            text-align: left;
            margin-bottom: 20px;
        }

        .login-form label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 600;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            border: none;
            border-radius: 4px;
            background-color: var(--input-bg);
            color: var(--dark-bg);
            font-size: 16px;
            outline: none;
        }
        .links {
            text-align: right;
            margin-top: 10px;
            margin-bottom: 25px; /* Adicionei margem para separar do botão ENTRAR */
            font-size: 13px;
            line-height: 1.5;
        }

        .forgot-password, .register-text a {
            color: var(--link-color);
            text-decoration: none;
        }

        .register-text a {
            font-weight: 600;
        }

        .botoes-container {
            width: 100%;
        }
        .btn {
            display: block; /* Essencial para que o width e margin: auto funcionem */
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none; /* Remove sublinhado dos links */
            text-align: center; /* Centraliza o texto dentro do link */
            width: 85%; /* Defina a largura desejada, 85% é um bom tamanho */
            margin: 15px auto; /* 15px de margem vertical e auto nas laterais para centralizar */
        }
        .btn-login-full {
            background-color: var(--primary-color);
            color: var(--text-color);
            margin-top: 0; 
        }

        .btn-login-full:hover {
            background-color: #6a0dad;
        }
        .btn-adm-full {
            background-color: var(--primary-color);
            color: var(--text-color);
           
        }

        .btn-adm-full:hover {
            background-color: #6a0dad;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="image-section"></div>

        <div class="form-section">
            <div class="logo">
                <h1>TECHFIT</h1>
                <p>ACADEMIA</p>
            </div>

            <h2>LOGIN</h2>

            <?php
            if (isset($_SESSION['erro_login'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['erro_login']) . '</div>';
                unset($_SESSION['erro_login']);
            }

            if (isset($_SESSION['sucesso_cadastro'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['sucesso_cadastro']) . '</div>';
                unset($_SESSION['sucesso_cadastro']);
            }

            if (isset($_SESSION['sucesso_recuperacao'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['mensagem_recuperacao']) . '</div>';
                unset($_SESSION['sucesso_recuperacao']);
                unset($_SESSION['mensagem_recuperacao']);
            }
            ?>

            <form method="POST" action="/login">
                <div class="input-group">
                    <label for="usuario">E-mail ou Usuário:</label>
                    <input type="text" id="usuario" name="usuario" 
                           placeholder="Ex: seuemail@dominio.com" required>
                </div>

                <div class="input-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" 
                           placeholder="Digite sua senha" required>
                </div>

                <button type="submit" class="submit-button">ENTRAR</button>

                <div class="links">
                    <a href="/esqueceu-senha">Esqueceu a senha?</a>
                </div>

                <div class="divider">
                    <span>OU</span>
                </div>

                <div class="links">
                    Não tem uma conta? <a href="/cadastro"><strong>Cadastre-se</strong></a>
                </div>
            </form>

            <div class="info-box">
                <strong>📌 Informações de Login:</strong><br>
                • <strong>Alunos:</strong> Use seu e-mail e CPF (somente números)<br>
                • <strong>Admin:</strong> adm@techfit.com / TechF!tAdm#2025$
            </div>
        </div>
    </div>
</body>
</html>