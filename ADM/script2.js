// 1. FUNCIONALIDADE DA NAVEGAÇÃO DE PERÍODO
const periodNav = document.getElementById('periodNav');
const navButtons = periodNav.querySelectorAll('.nav-button');

navButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Remove a classe 'active' de todos os botões
        navButtons.forEach(btn => btn.classList.remove('active'));

        // Adiciona a classe 'active' ao botão clicado
        button.classList.add('active');

        // Pega o período para simular a mudança de dados
        const period = button.getAttribute('data-period');
        
        // Simulação de carregamento de dados
        console.log(`Período selecionado: ${period}`);
        
        // Exibe um alerta simples
        alert(`Atualizando dados para o período: ${period.toUpperCase().replace('-', ' ')}...`);
        
        // Em um projeto real, você usaria essa variável 'period' para buscar os dados no servidor.
    });
});