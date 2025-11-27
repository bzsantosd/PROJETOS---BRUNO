<?php
// View/auth/cadastro.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - TechFit Academia</title>
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
            width: 100%;
            max-width: 600px;
            background-color: rgba(0, 0, 0, 0.9);
            box-shadow: 0 0 50px rgba(138, 43, 226, 0.3);
            border-radius: 20px;
            border: 1px solid rgba(138, 43, 226, 0.2);
            padding: 50px 40px;
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

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #bbb;
        }

        .required {
            color: #ff4444;
        }

        .input-group input,
        .input-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid rgba(138, 43, 226, 0.3);
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--color-text-light);
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .input-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .input-group input:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: var(--color-purple-primary);
            background-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 20px rgba(138, 43, 226, 0.3);
        }

        .input-group input::placeholder,
        .input-group textarea::placeholder {
            color: #666;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
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

        .info-box {
            background: rgba(138, 43, 226, 0.1);
            border-left: 3px solid var(--color-purple-primary);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 0.85rem;
            color: #aaa;
        }

        @media (max-width: 650px) {
            .container {
                padding: 40px 25px;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>TECHFIT</h1>
            <p>ACADEMIA</p>
        </div>

        <h2>CADASTRO</h2>

        <?php
        if (isset($_SESSION['erro_cadastro'])) {
            echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['erro_cadastro']) . '</div>';
            unset($_SESSION['erro_cadastro']);
        }
        ?>

        <div class="info-box">
            <strong>📌 Informações importantes:</strong><br>
            • Após o cadastro, use seu <strong>e-mail</strong> e <strong>CPF</strong> (somente números) para fazer login.<br>
            • Todos os campos marcados com <span class="required">*</span> são obrigatórios.
        </div>

        <form method="POST" action="/cadastro">
            <div class="input-group">
                <label for="nome">Nome Completo <span class="required">*</span></label>
                <input type="text" id="nome" name="nome" 
                       placeholder="Digite seu nome completo" required>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label for="email">E-mail <span class="required">*</span></label>
                    <input type="email" id="email" name="email" 
                           placeholder="seu@email.com" required>
                </div>

                <div class="input-group">
                    <label for="cpf">CPF <span class="required">*</span></label>
                    <input type="text" id="cpf" name="cpf" 
                           placeholder="000.000.000-00" maxlength="14" required>
                </div>
            </div>

            <div class="input-group">
                <label for="contato">Telefone / WhatsApp</label>
                <input type="text" id="contato" name="contato" 
                       placeholder="(00) 00000-0000" maxlength="15">
            </div>

            <div class="input-group">
                <label for="endereco">Endereço</label>
                <textarea id="endereco" name="endereco" 
                          placeholder="Rua, número, bairro, cidade - UF"></textarea>
            </div>

            <button type="submit" class="submit-button">CADASTRAR</button>

            <div class="links">
                Já tem uma conta? <a href="/login"><strong>Fazer Login</strong></a>
            </div>
        </form>
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

        document.getElementById('contato').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }
                e.target.value = value;
            }
        });
    </script>
</body>
</html>