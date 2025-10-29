// VARIÁVEL GLOBAL PARA A ÁREA DE MENSAGENS
const messageArea = document.getElementById('messageArea');

/**
 * Função auxiliar para exibir mensagens em uma área específica do HTML.
 * @param {string} message - A mensagem a ser exibida.
 * @param {string} type - O tipo da mensagem (ex: 'success', 'error', 'info').
 */
function displayMessage(message, type = 'info') {
    // 1. Limpa qualquer mensagem anterior
    if (messageArea) {
        messageArea.innerHTML = '';
        messageArea.className = 'message-box'; // Reseta a classe base

        // 2. Cria o elemento da mensagem
        const msgElement = document.createElement('p');
        msgElement.textContent = message;

        // 3. Adiciona classes CSS para estilização (necessário ter CSS definido para estas classes)
        messageArea.classList.add(`message-${type}`);
        
        // 4. Adiciona a mensagem à área
        messageArea.appendChild(msgElement);

        // Opcional: Limpar a mensagem após um tempo
        setTimeout(() => {
            messageArea.innerHTML = '';
            messageArea.className = 'message-box'; // Volta para a classe base
        }, 5000); // Mensagem some após 5 segundos
    } else {
        // Fallback caso a área de mensagem não exista (pode usar console.log ou alert)
        console.warn(`Área de mensagem (ID 'messageArea') não encontrada. Mensagem: ${message}`);
    }
}


// 1. FUNCIONALIDADE DO BOTÃO "ENTRAR"
const btnEntrar = document.getElementById('btnEntrar');
const usuarioInput = document.getElementById('usuario');
const senhaInput = document.getElementById('senha');

if (btnEntrar) {
    btnEntrar.addEventListener('click', function(event) {
        event.preventDefault(); // Impede o envio do formulário, se for o caso
        
        const usuario = usuarioInput.value.trim();
        const senha = senhaInput.value.trim();

        // Validação de campos vazios
        if (usuario === '' || senha === '') {
            displayMessage('Preencha os campos Usuário e Senha para continuar.', 'error');
            return;
        }

        // SIMULAÇÃO DE LOGIN
        if (usuario === 'admin' && senha === 'techfit2025') {
            displayMessage('Login ADM bem-sucedido! Redirecionando...', 'success');
            // Em um projeto real: window.location.href = '/dashboard-admin.html';
        } else if (usuario.length > 0 && senha.length > 0) {
            // Assume que qualquer outro preenchimento é uma tentativa de aluno
            displayMessage(`Bem-vindo(a) ${usuario}! Login de aluno realizado com sucesso.`, 'success');
        } else {
            // Caso de falha de login genérica
            displayMessage('Usuário ou Senha incorretos. Tente novamente.', 'error');
        }
    });
}


// 2. FUNCIONALIDADE DO BOTÃO "ADM"
const btnAdm = document.getElementById('btnAdm');

if (btnAdm) {
    btnAdm.addEventListener('click', function() {
        displayMessage('Acesso Rápido ADM: Use "admin" e "techfit2025" para testar o login de administrador.', 'info');
    });
}


// 3. FUNCIONALIDADE DOS LINKS
const forgotPasswordLink = document.getElementById('forgotPassword');
const registerLink = document.getElementById('registerLink');

if (forgotPasswordLink) {
    forgotPasswordLink.addEventListener('click', function(event) {
        event.preventDefault(); // Impede o link de recarregar a página
        displayMessage('A função de recuperação de senha será implementada em breve.', 'info');
    });
}

if (registerLink) {
    registerLink.addEventListener('click', function(event) {
        event.preventDefault();
        displayMessage('Redirecionando para a página de Cadastro de novo usuário...', 'info');
        // Em um projeto real: window.location.href = '/cadastro.html';
    });
}