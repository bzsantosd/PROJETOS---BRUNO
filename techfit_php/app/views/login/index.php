<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFit Academia - Login</title>
    <link rel="stylesheet" href="/techfit/public/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        
        <div class="image-section">
        </div>

        <div class="login-section">
            <div class="login-box">
                <h1 class="login-title">LOGIN</h1>
                
                <img src="/techfit/public/images/Logotipo.png" alt="Logotipo TechFit Academia" class="background-image">
                
                <?php
                // Exibir mensagens de erro
                if (isset($_SESSION['erro'])) {
                    echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['erro']) . '</div>';
                    unset($_SESSION['erro']);
                }
                
                // Exibir mensagens de sucesso
                if (isset($_SESSION['sucesso'])) {
                    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['sucesso']) . '</div>';
                    unset($_SESSION['sucesso']);
                }
                ?>
                
                <form action="/techfit/login/processar" method="POST" id="loginForm" class="login-form">
                    <label for="usuario">Usuário (Email):</label>
                    <input type="email" id="usuario" name="usuario" required>

                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                    
                    <div class="links">
                        <a href="/techfit/esqueceu-senha" id="forgotPassword" class="forgot-password">Esqueceu a senha?</a>
                        <span class="register-text"> <br>
                            Não tem uma conta? <a href="/techfit/cadastro">Cadastre-se</a>
                        </span>
                    </div>
                    
                    <div class="botoes-container"> 
                        <button type="submit" class="btn btn-login-full">Entrar</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            text-align: center;
        }
        
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
    
    <script src="/techfit/public/js/script.js"></script>
</body>
</html>