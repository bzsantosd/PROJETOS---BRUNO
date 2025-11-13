<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu Senha - TechFit Academia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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
            background-color: var(--color-dark);
            color: var(--color-text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            display: flex;
            width: 900px;
            min-height: 450px;
            background-color: var(--color-dark);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            border-radius: 12px;
        }

        .image-section {
            width: 40%;
            background-image: url('/images/academia.jpg');
            background-size: cover;
            background-position: center;
        }

        .form-section {
            width: 60%;
            background-color: var(--color-dark);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-section h2 {
            font-size: 2.0rem;
            font-weight: bold;
            color: white;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-section p {
            text-align: center;
            margin-bottom: 20px;
            color: var(--color-placeholder);
        }

        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-error {
            background-color: #ff4444;
            color: white;
        }

        .alert-success {
            background-color: #00C851;
            color: white;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
            font-weight: bold;
            color: var(--color-text-light);
        }

        .input-group input {
            width: 100%;
            padding: 10px 15px;
            border: none;
            background-color: var(--color-input-bg);
            color: var(--color-text-light);
            font-size: 1rem;
            border-radius: 5px;
        }

        .input-group input:focus {
            outline: none;
            border-bottom: 2px solid var(--color-purple-primary);
        }

        .submit-button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #a020f0, #8a2be2);
            color: var(--color-text-light);
            font-size: 1.2rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .submit-button:hover {
            background: linear-gradient(to right, #8a2be2, #a020f0);
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: var(--color-purple-primary);
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
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
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-section"></div>

        <div class="form-section">
            <h2>RECUPERAR SENHA</h2>
            <p>Insira seu e-mail e CPF para buscar sua conta.</p>

            <?php
            if (isset($_SESSION['erro_recuperacao'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['erro_recuperacao']) . '</div>';
                unset($_SESSION['erro_recuperacao']);
            }

            if (isset($_SESSION['sucesso_recuperacao'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['mensagem_recuperacao']) . '</div>';
                echo '<div class="alert alert-success"><strong>Sua senha de acesso é o seu CPF (somente números)</strong></div>';
                unset($_SESSION['sucesso_recuperacao']);
                unset($_SESSION['mensagem_recuperacao']);
            }
            ?>

            <form method="POST" action="/esqueceu-senha">
                <div class="input-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="Ex: seuemail@dominio.com" required>
                </div>

                <div class="input-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" required>
                </div>

                <button type="submit" class="submit-button">BUSCAR CONTA</button>

                <div class="links">
                    <a href="/login">Lembrei minha senha. Voltar ao Login</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Máscara CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>