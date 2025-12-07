// cadastro.js

document.addEventListener('DOMContentLoaded', () => {
    // Seleciona o formulário pelo seu elemento pai (form-section) ou use o seletor 'form'
    const cadastroForm = document.querySelector('.form-section form');

    if (cadastroForm) {
        cadastroForm.addEventListener('submit', (event) => {
            // Evita o comportamento de submissão padrão do formulário (que enviaria para login.html)
            event.preventDefault(); 

            // Coleta os valores do formulário
            const nome = document.getElementById('nome').value;
            const cpf = document.getElementById('cpf').value;
            const email = document.getElementById('email').value;
            const senha = document.getElementById('senha').value;
            const repitaSenha = document.getElementById('repita-senha').value;

            // --- Lógica de Validação Básica ---
            if (senha !== repitaSenha) {
                alert('As senhas digitadas não são iguais. Por favor, verifique.');
                return; // Impede o cadastro
            }
            if (!nome || !cpf || !email || !senha) {
                alert('Por favor, preencha todos os campos obrigatórios.');
                return;
            }

            // --- 1. Armazenar os Dados (Simulação de Cadastro) ---
            const userData = {
                nome: nome,
                cpf: cpf,
                email: email,
                // Armazenar a senha em localStorage não é seguro, mas é feito aqui para fins de simulação de login:
                senha: senha, 
                // Você pode adicionar um token de login simulado
                loggedIn: true 
            };

            // Salva os dados do usuário no localStorage
            localStorage.setItem('currentUserData', JSON.stringify(userData));

            // Feedback visual e redirecionamento (Simulação de Sucesso)
            alert('✅ Cadastro realizado com sucesso! Você será redirecionado para o Login.');
            
            // --- 2. Redirecionamento ---
            // Redireciona para a página de login para que o usuário "entre" na conta.
            // O caminho precisa ser ajustado para onde seu login.html está, se for diferente de login.html
            window.location.href = '/techfit_php/public/login.html'; 
        });
    }
});