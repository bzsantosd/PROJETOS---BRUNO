// cadastro.js

document.addEventListener('DOMContentLoaded', () => {
    const cadastroForm = document.querySelector('.form-section form');
    const notificationElement = document.getElementById('custom-notification');

    /**
     * Função para mostrar a notificação in-page e esconder após 4 segundos.
     * @param {string} message - A mensagem a ser exibida.
     * @param {string} type - O tipo de notificação ('success' ou 'error').
     * @param {number} duration - Duração em milissegundos antes de esconder.
     */
    function showNotification(message, type = 'success', duration = 4000) {
        // Define o conteúdo e a classe de estilo
        notificationElement.textContent = message;
        notificationElement.className = 'custom-alert show'; // Remove classes anteriores e adiciona 'show'

        // Define a cor da notificação (vermelha para erro)
        if (type === 'error') {
            notificationElement.classList.add('error');
        } else {
            notificationElement.classList.remove('error');
        }

        // Esconde a notificação após o tempo definido
        setTimeout(() => {
            notificationElement.classList.remove('show');
        }, duration);
    }
    
    // RegEx para formato de E-mail: algo@algo.dominio
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
    // RegEx para formato de CPF: 999.999.999-99
    const cpfRegex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;

    if (cadastroForm) {
        cadastroForm.addEventListener('submit', (event) => {
            event.preventDefault(); 

            // Coleta e trata os valores do formulário
            const nome = document.getElementById('nome').value.trim();
            const cpf = document.getElementById('cpf').value.trim();
            // NOVOS: Coleta Telefone e Endereço
            const telefone = document.getElementById('telefone').value.trim();
            const endereco = document.getElementById('endereco').value.trim();
            
            const email = document.getElementById('email').value.trim();
            const senha = document.getElementById('senha').value;
            const repitaSenha = document.getElementById('repita-senha').value;

            // --- Lógica de Validação ---
            
            // 1. Validação de Campos Vazios
            if (!nome || !cpf || !telefone || !endereco || !email || !senha || !repitaSenha) {
                showNotification('🚨 Por favor, preencha todos os campos obrigatórios.', 'error');
                return;
            }

            // 2. Validação de Senhas
            if (senha !== repitaSenha) {
                showNotification('🚨 As senhas digitadas não são iguais. Por favor, verifique.', 'error');
                return; 
            }

            // 3. Validação de E-mail (Formato Tradicional)
            if (!emailRegex.test(email)) {
                showNotification('🚨 O formato do E-mail está incorreto. Use o formato: exemplo@dominio.com', 'error');
                return;
            }

            // 4. Validação de CPF (Formato Tradicional: XXX.XXX.XXX-XX)
            if (!cpfRegex.test(cpf)) {
                showNotification('🚨 O formato do CPF está incorreto. Use o formato: 123.456.789-00', 'error');
                return;
            }

            // --- Armazenar os Dados (Simulação de Cadastro) ---
            const userData = {
                nome: nome,
                cpf: cpf,
                telefone: telefone, // Incluído
                endereco: endereco, // Incluído
                email: email,
                senha: senha, 
                loggedIn: true 
            };

            localStorage.setItem('currentUserData', JSON.stringify(userData));

            // Feedback visual de sucesso com a notificação na tela
            showNotification('✅ Cadastro realizado com sucesso! Você será redirecionado para o Login.', 'success');
            
            // --- Redirecionamento (Atrasado para dar tempo de ver a notificação) ---
            setTimeout(() => {
                window.location.href = '/techfit_php/public/login.html'; 
            }, 3000); // Redireciona após 3 segundos
        });
    }
});