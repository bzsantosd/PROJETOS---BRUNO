/**
 * Lógica básica de login no lado do cliente (Frontend).
 * ATENÇÃO: Em um ambiente de produção, esta validação DEVE ser feita no servidor (Backend) 
 * por motivos de segurança.
 */

// Senha e Usuário específicos para o ADM (SUA SENHA FORTE)
const ADMIN_USERNAME = "adm";
const ADMIN_PASSWORD = "TechF!tAdm#2025$"; 

// Usuários comuns (simulando um pequeno banco de dados de usuários cadastrados)
// Em produção, isso viria de um banco de dados real.
const USERS_DB = {
    "aluno@email.com": "senha123",
    "maria@email.com": "mariafitness",
    // Adicione mais usuários cadastrados aqui conforme forem se cadastrando
};

// Referências aos elementos
const loginForm = document.getElementById('loginForm');
const usuarioInput = document.getElementById('usuario');
const senhaInput = document.getElementById('senha');


// --- LÓGICA DE LOGIN COMUM E ADM (Ao submeter o formulário) ---
if (loginForm) {
    loginForm.addEventListener('submit', function(event) {
        // Impede o envio padrão do formulário (para evitar recarregar a página)
        event.preventDefault(); 
        
        const username = usuarioInput.value.trim();
        const password = senhaInput.value.trim();

        // 1. Verifica se é o ADM
        if (username.toLowerCase() === ADMIN_USERNAME && password === ADMIN_PASSWORD) {
            alert('Acesso de Administrador concedido!');
            // Redireciona para o painel de ADM
            window.location.href = "/PAINEL ADM/index.html"; 
        } 
        // 2. Verifica se é um usuário comum cadastrado
        else if (USERS_DB[username] === password) {
            alert(`Bem-vindo, ${username}! Acesso concedido.`);
            // Redireciona para a página de usuário comum
            window.location.href = "/ENTRAR/entrar.html"; 
        }
        // 3. Credenciais Inválidas
        else {
            alert('Usuário ou senha incorretos. Verifique suas credenciais ou cadastre-se.');
        }
    });
}
