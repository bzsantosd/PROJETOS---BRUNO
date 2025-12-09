document.getElementById('loginForm').addEventListener('submit', async function(event) {
    // Impede o envio padrão do formulário
    event.preventDefault(); 

    document.addEventListener('DOMContentLoaded', () => {
    // 1. Defina as credenciais de administrador
    const ADMIN_EMAIL = 'admin@techfit.com';
    const ADMIN_PASSWORD = 'Admin123!';
    const ADMIN_PAGE = 'adm.html';

    // 2. Selecione os elementos importantes
    const loginForm = document.querySelector('.login-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const errorMessage = document.querySelector('.error-message');

    // 3. Adicione o ouvinte de evento para o envio do formulário
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            // Previne o envio padrão do formulário (que recarregaria a página)
            event.preventDefault();

            // Oculta qualquer mensagem de erro anterior
            errorMessage.style.display = 'none';

            // Pega os valores dos campos
            const email = emailInput.value.trim();
            const password = passwordInput.value.trim();

            // 4. Lógica de Verificação
            if (email === ADMIN_EMAIL && password === ADMIN_PASSWORD) {
                // Credenciais CORRETAS: Redireciona para a página do administrador
                window.location.href = ADMIN_PAGE;
            } else {
                // Credenciais INCORRETAS: Exibe a mensagem de erro
                errorMessage.textContent = 'Email ou senha incorretos. Tente novamente.';
                errorMessage.style.display = 'block';
            }
        });
    }
});

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
                
                // CORRIGIDO: Redireciona para o arquivo 'cliente.php'
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