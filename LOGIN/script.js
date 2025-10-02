// Função auxiliar para exibir alertas
function showAlert(message) {
    alert(message);
}

// 1. FUNCIONALIDADE DO BOTÃO "ENTRAR"
const btnEntrar = document.getElementById('btnEntrar');
const usuarioInput = document.getElementById('usuario');
const senhaInput = document.getElementById('senha');

btnEntrar.addEventListener('click', function(event) {
    
    const usuario = usuarioInput.value.trim();
    const senha = senhaInput.value.trim();

    // Validação de campos vazios
    if (usuario === '' || senha === '') {
        showAlert('Preencha os campos Usuário e Senha para continuar.');
        return;
    }

    // SIMULAÇÃO DE LOGIN
    if (usuario === 'admin' && senha === 'techfit2025') {
        showAlert('Login ADM bem-sucedido! Redirecionando...');
        // Em um projeto real: window.location.href = '/dashboard-admin.html';
    } else if (usuario.length > 0 && senha.length > 0) {
        // Assume que qualquer outro preenchimento é uma tentativa de aluno
        showAlert(`Bem-vindo(a) ${usuario}! Login de aluno realizado com sucesso.`);
    } else {
        // Caso de falha de login genérica
        showAlert('Usuário ou Senha incorretos. Tente novamente.');
    }
});


// 2. FUNCIONALIDADE DO BOTÃO "ADM"
const btnAdm = document.getElementById('btnAdm');

btnAdm.addEventListener('click', function() {
    showAlert('Acesso Rápido ADM: Use "admin" e "techfit2025" para testar o login de administrador.');
});

// 3. FUNCIONALIDADE DOS LINKS
const forgotPasswordLink = document.getElementById('forgotPassword');
const registerLink = document.getElementById('registerLink');

forgotPasswordLink.addEventListener('click', function(event) {
    event.preventDefault(); // Impede o link de recarregar a página
    showAlert('A função de recuperação de senha será implementada em breve.');
});

registerLink.addEventListener('click', function(event) {
    event.preventDefault();
    showAlert('Redirecionando para a página de Cadastro de novo usuário...');
});