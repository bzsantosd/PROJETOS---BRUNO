<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário - TechFit Academia</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/techfit/public/css/cadastro.css">
</head>
<body>
<div class="container"> 
    
    <div class="image-section">
    </div>

    <div class="form-section">
    
        <h2>CADASTRO</h2>
        
        <?php
        // Exibir erros de validação
        if (isset($_SESSION['erros']) && !empty($_SESSION['erros'])) {
            echo '<div class="alert alert-danger"><ul style="margin: 0; padding-left: 20px;">';
            foreach ($_SESSION['erros'] as $erro) {
                echo '<li>' . htmlspecialchars($erro) . '</li>';
            }
            echo '</ul></div>';
            unset($_SESSION['erros']);
        }
        
        // Recuperar dados do formulário em caso de erro
        $formData = $_SESSION['form_data'] ?? [];
        unset($_SESSION['form_data']);
        ?>
        
        <form action="/techfit/cadastro/processar" method="POST" id="cadastroForm"> 
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" 
                       id="nome" 
                       name="nome" 
                       placeholder="Ex: Jorge Ferreira" 
                       value="<?php echo htmlspecialchars($formData['nome'] ?? ''); ?>"
                       required>
            </div>

            <div class="input-group">
                <label for="cpf">CPF:</label>
                <input type="text" 
                       id="cpf" 
                       name="cpf" 
                       placeholder="Ex: 123.456.789-10" 
                       pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" 
                       title="Formato: 123.456.789-10"
                       value="<?php echo htmlspecialchars($formData['cpf'] ?? ''); ?>"
                       required>
            </div>

            <div class="input-group">
                <label for="email">E-mail:</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       placeholder="Ex: exemplo@gmail.com"
                       value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                       required>
            </div>

            <div class="input-group">
                <label for="senha">Senha:</label>
                <input type="password" 
                       id="senha" 
                       name="senha" 
                       minlength="6"
                       required>
                <small style="color: #666;">Mínimo 6 caracteres</small>
            </div>

            <div class="input-group">
                <label for="repita-senha">Repita a senha:</label>
                <input type="password" 
                       id="repita-senha" 
                       name="repita-senha" 
                       required>
            </div>
            
            <button type="submit" class="register-button">
                CADASTRAR
            </button>
            
            <div class="login-link" style="text-align: center; margin-top: 15px;">
                Já tem uma conta? <a href="/techfit/login">Faça login</a>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Sucesso -->
<div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="modalSuccessLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-body p-4 text-center">
                <h5 class="mb-0" style="color: var(--color-purple-primary);">CADASTRO FEITO COM SUCESSO</h5>
            </div>
            <div class="modal-footer flex-nowrap p-0 justify-content-center text-center"> 
                <a href="/techfit/login" class="btn btn-primary">Ir ao Login</a>
            </div>
        </div>
    </div>
</div>

<style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    
    .alert-danger ul {
        text-align: left;
    }
    
    .login-link a {
        color: #5d0f99;
        text-decoration: none;
        font-weight: 600;
    }
    
    .login-link a:hover {
        text-decoration: underline;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Máscara de CPF
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
    }
});

// Validação de senha
document.getElementById('cadastroForm').addEventListener('submit', function(e) {
    const senha = document.getElementById('senha').value;
    const repitaSenha = document.getElementById('repita-senha').value;
    
    if (senha !== repitaSenha) {
        e.preventDefault();
        alert('As senhas não coincidem!');
        return false;
    }
    
    if (senha.length < 6) {
        e.preventDefault();
        alert('A senha deve ter pelo menos 6 caracteres!');
        return false;
    }
});
</script>
</body>
</html>