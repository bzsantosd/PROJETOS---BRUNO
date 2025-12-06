document.getElementById('cadastroForm').addEventListener('submit', async function(event) {
    // Impede o envio padrão do formulário
    event.preventDefault();

    // Captura os valores dos campos
    const nome = document.getElementById('nome').value.trim();
    const cpf = document.getElementById('cpf').value.trim();
    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value.trim();
    const repitaSenha = document.getElementById('repita-senha').value.trim();
    
    const errorMessage = document.getElementById('error-message');
    const submitButton = event.target.querySelector('button[type="submit"]');

    // Limpa mensagens de erro
    if (errorMessage) {
        errorMessage.textContent = '';
        errorMessage.style.display = 'none';
    }

    // Validação no frontend
    if (!nome || !email || !senha || !repitaSenha) {
        if (errorMessage) {
            errorMessage.textContent = '⚠️ Preencha todos os campos obrigatórios!';
            errorMessage.style.display = 'block';
        }
        return;
    }

    if (senha !== repitaSenha) {
        if (errorMessage) {
            errorMessage.textContent = '⚠️ As senhas não coincidem!';
            errorMessage.style.display = 'block';
        }
        return;
    }

    if (senha.length < 6) {
        if (errorMessage) {
            errorMessage.textContent = '⚠️ A senha deve ter no mínimo 6 caracteres!';
            errorMessage.style.display = 'block';
        }
        return;
    }

    // Desabilita o botão durante o cadastro
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Cadastrando...';
    }

    try {
        // Envia requisição para o backend
        const response = await fetch('/api/cadastro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                nome: nome,
                cpf: cpf,
                email: email,
                senha: senha,
                'repita-senha': repitaSenha
            })
        });

        const data = await response.json();

        if (data.success) {
            // Cadastro bem-sucedido!
            
            // Mostra mensagem de sucesso (se você tiver um modal ou alert)
            alert('✅ Cadastro realizado com sucesso! Faça login para continuar.');
            
            // Redireciona para a página de login
            window.location.href = '/login.html';
            
        } else {
            // Cadastro falhou
            if (errorMessage) {
                errorMessage.textContent = data.message || '❌ Erro ao cadastrar. Tente novamente.';
                errorMessage.style.display = 'block';
            }
            
            // Reabilita o botão
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Cadastrar';
            }
        }
    } catch (error) {
        console.error('Erro ao fazer cadastro:', error);
        
        if (errorMessage) {
            errorMessage.textContent = '❌ Erro ao conectar com o servidor. Tente novamente.';
            errorMessage.style.display = 'block';
        }
        
        // Reabilita o botão
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Cadastrar';
        }
    }
});