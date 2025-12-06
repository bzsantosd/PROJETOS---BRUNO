document.getElementById('loginForm').addEventListener('submit', async function(event) {
    // Impede o envio padrão do formulário
    event.preventDefault(); 

    const emailInput = document.getElementById('usuario').value.trim();
    const passwordInput = document.getElementById('senha').value.trim();
    const errorMessage = document.getElementById('error-message');
    const submitButton = event.target.querySelector('button[type="submit"]');

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
        // 4. Envia requisição para o backend
        const response = await fetch('/api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: emailInput,
                senha: passwordInput
            })
        });

        const data = await response.json();

        // 5. Verifica a resposta do servidor
        if (data.success) {
            // Login bem-sucedido!
            
            // Redireciona de acordo com o tipo de usuário
            if (data.user.tipo === 'admin') {
                window.location.href = '/PAINEL ADM/adm.html';
            } else {
                window.location.href = '/techfit_php/public/tela ao logan.html';
            }
        } else {
            // Login falhou
            errorMessage.textContent = data.message || '❌ Email ou senha incorretos!';
            errorMessage.style.display = 'block';
            
            // Reabilita o botão
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Entrar';
            }
        }
    } catch (error) {
        console.error('Erro ao fazer login:', error);
        errorMessage.textContent = '❌ Erro ao conectar com o servidor. Tente novamente.';
        errorMessage.style.display = 'block';
        
        // Reabilita o botão
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Entrar';
        }
    }
});