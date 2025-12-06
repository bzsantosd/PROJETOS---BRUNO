document.getElementById('loginForm').addEventListener('submit', function(event) {
    // ESSENCIAL: Impede que o formulário navegue sem validação
    event.preventDefault(); 

    const emailInput = document.getElementById('usuario').value.trim();
    const passwordInput = document.getElementById('senha').value.trim();
    const errorMessage = document.getElementById('error-message');

    // 1. Limpa mensagens de erro
    errorMessage.textContent = '';
    errorMessage.style.display = 'none';

    // 2. Credenciais Fixas (Mockup)
    const ADMIN_EMAIL = 'admin@techfit.com';
    const ADMIN_PASSWORD = 'techfit_adm123';
    
    // Clientes cadastrados (aqui no front-end é apenas um mockup)
    const CUSTOMER_CREDENTIALS = {
        'cliente@techfit.com': 'senha123',
        'bruno@techfit.com': 'bruno123'
        // Adicione outros clientes aqui no formato 'email': 'senha'
    };

    // 3. Lógica de Validação e Redirecionamento
    if (emailInput === ADMIN_EMAIL && passwordInput === ADMIN_PASSWORD) {
        // Acesso de Administrador
        window.location.href = '/PAINEL ADM/adm.html'; 
    } else if (CUSTOMER_CREDENTIALS[emailInput] === passwordInput) {
        // Acesso de Cliente (Usuário Cadastrado)
        window.location.href = '/techfit_php/public/tela ao logan.html'; 
    } else {
        // 4. Bloqueia o acesso e mostra a mensagem de erro
        errorMessage.textContent = 'Usuário ou Senha inválidos. Verifique suas credenciais.';
        errorMessage.style.display = 'block';
    }
});