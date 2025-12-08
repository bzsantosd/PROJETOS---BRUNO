document.getElementById('loginForm').addEventListener('submit', async function(event) {
    // Impede o envio padrão do formulário
    event.preventDefault(); 

    const emailInput = document.getElementById('usuario').value.trim();
    const passwordInput = document.getElementById('senha').value.trim();
    const errorMessage = document.getElementById('error-message');
    // Busca o botão pelo tipo 'submit' e pela classe CSS correta.
    const submitButton = event.target.querySelector('button[type="submit"].btn-login-full');

    // 1. Limpa mensagens de erro
    errorMessage.textContent = '';
    errorMessage.style.display = 'none';

    // 2. Validação básica
    if (!emailInput || !passwordInput) {
        errorMessage.textContent = '⚠️ Preencha todos os campos!';
        errorMessage.style.display = 'block';
        return;
    }

    // 3. Desabilita o botão durante o login
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Entrando...';
    }

    try {
        // **NOVA LÓGICA: Verifica no Local Storage (SIMULAÇÃO)**
        const userDataString = localStorage.getItem('currentUserData');
        
        if (userDataString) {
            const userData = JSON.parse(userDataString);
            
            // Verifica se o email e a senha batem com o que foi salvo no cadastro.js
            if (userData.email === emailInput && userData.senha === passwordInput) {
                // Login bem-sucedido (SIMULADO)
                
                // CORRIGIDO: Redireciona para o arquivo 'cliente.html'
                window.location.href = '/techfit_php/public/cliente.html'; 
                return; // Encerra a função
            }
        }
        
        // Se chegou aqui, as credenciais não bateram ou não há dados salvos
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