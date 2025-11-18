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
            --color-dark: #000000;
            --color-text-light: #ffffff;
            --color-purple-primary: #8a2be2;
            --color-input-bg: #222222;
            --color-placeholder: #aaaaaa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: var(--color-text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            display: flex;
            width: 900px;
            min-height: 500px;
            background-color: rgba(0, 0, 0, 0.8);
            box-shadow: 0 0 50px rgba(138, 43, 226, 0.3);
            overflow: hidden;
            border-radius: 20px;
            border: 1px solid rgba(138, 43, 226, 0.2);
        }

        .image-section {
            width: 45%;
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.3), rgba(75, 0, 130, 0.5)),
                        url('/images/academia.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .image-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.4), transparent);
        }

        .form-section {
            width: 55%;
            background-color: rgba(0, 0, 0, 0.9);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo h1 {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #8a2be2, #a020f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }

        .logo p {
            color: #aaa;
            font-size: 0.9rem;
        }

        h2 {
            font-size: 2rem;
            font-weight: bold;
            color: white;
            margin-bottom: 30px;
            text-align: center;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-error {
            background-color: rgba(255, 68, 68, 0.2);
            border: 1px solid #ff4444;
            color: #ff6b6b;
        }

        .alert-success {
            background-color: rgba(0, 200, 81, 0.2);
            border: 1px solid #00C851;
            color: #00ff88;
        }

        .input-group {
            margin-bottom: 25px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 1rem;
            font-weight: 600;
            color: #bbb;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid rgba(138, 43, 226, 0.3);
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--color-text-light);
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--color-purple-primary);
            background-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 20px rgba(138, 43, 226, 0.3);
        }

        .input-group input::placeholder {
            color: #666;
        }

        .submit-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #a020f0, #8a2be2);
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(138, 43, 226, 0.4);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .links {
            text-align: center;
            margin-top: 25px;
        }

        .links a {
            color: var(--color-purple-primary);
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .links a:hover {
            color: #a020f0;
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }

        .divider span {
            color: #666;
            padding: 0 10px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(138, 43, 226, 0.3);
        }

        .info-box {
            background: rgba(138, 43, 226, 0.1);
            border-left: 3px solid var(--color-purple-primary);
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 0.85rem;
            color: #aaa;
        }

        @media (max-width: 950px) {
            .container {
                flex-direction: column;
                width: 95%;
            }
            .image-section {
                width: 100%;
                height: 150px;
            }
            .form-section {
                width: 100%;
                padding: 40px 30px;
            }
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