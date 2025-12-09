document.getElementById('loginForm').addEventListener('submit', async function(event) {
    // Impede o envio padrão do formulário
    event.preventDefault(); 

    // 1. Defina as credenciais de administrador
    const ADMIN_EMAIL = 'admin@techfit.com';
    const ADMIN_PASSWORD = 'Admin123!';
    
    // CORREÇÃO: Usando caminho relativo para subir um nível (../)
    // Isso assume que adm.html está na pasta techfit_php/ (fora de public/)
    const ADMIN_PAGE = '/techfit_php/public/adm.html'; 

    // 2. Seleciona os valores dos campos
    const emailInput = document.getElementById('usuario').value.trim();
    const passwordInput = document.getElementById('senha').value.trim();
    const errorMessage = document.getElementById('error-message');
    const submitButton = event.target.querySelector('button[type="submit"].btn-login-full');

    // 3. Limpa mensagens de erro
    errorMessage.textContent = '';
    errorMessage.style.display = 'none';

    // 4. Validação básica
    if (!emailInput || !passwordInput) {
        errorMessage.textContent = '⚠️ Preencha todos os campos!';
        errorMessage.style.display = 'block';
        return;
    }

    // 5. Desabilita o botão durante o login
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Entrando...';
    }

    // 6. Lógica de Verificação de Administrador
    if (emailInput === ADMIN_EMAIL && passwordInput === ADMIN_PASSWORD) {
        // Credenciais CORRETAS: Redireciona para a página do administrador
        window.location.href = ADMIN_PAGE; 
        return; // Encerra a função após o redirecionamento
    }


    // 7. Lógica de Verificação de Usuário/Cliente (Simulação de Local Storage)
    try {
        const userDataString = localStorage.getItem('currentUserData');
        
        if (userDataString) {
            const userData = JSON.parse(userDataString);
            
            // Verifica se o email e a senha batem com o que foi salvo no cadastro.js
            if (userData.email === emailInput && userData.senha === passwordInput) {
                // Login bem-sucedido (SIMULADO)
                window.location.href = '/techfit_php/public/cliente.html';
                return; // Encerra a função
            }
        }
        
        // Se chegou aqui, as credenciais não bateram
        errorMessage.textContent = '❌ Email ou senha incorretos!';
        errorMessage.style.display = 'block';
            
        // Reabilita o botão
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Entrar';
        }

    } catch (error) {
        console.error('Erro ao fazer login:', error);
        errorMessage.textContent = '❌ Erro interno na simulação de login.';
        errorMessage.style.display = 'block';
        
        // Reabilita o botão
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Entrar';
        }
    }
});