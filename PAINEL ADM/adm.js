document.addEventListener('DOMContentLoaded', () => {
    // Obter referências aos botões
    const rendimentoMensalBtn = document.getElementById('rendimentoMensalBtn');
    const cadastrarProdutosBtn = document.getElementById('cadastrarProdutosBtn');

    // Adicionar listener de evento para o botão "RENDIMENTO MENSAL"
    rendimentoMensalBtn.addEventListener('click', () => {
        // Exemplo de funcionalidade: Alerta
        alert('Funcionalidade "Rendimento Mensal" acionada! (Simularia navegação para a tela de relatórios)');
        
        // Em um projeto real, você faria:
        // window.location.href = '/rendimento-mensal'; 
    });

    // Adicionar listener de evento para o botão "CADASTRAR PRODUTOS"
    cadastrarProdutosBtn.addEventListener('click', () => {
        // Exemplo de funcionalidade: Alerta
        alert('Funcionalidade "Cadastrar Produtos" acionada! (Simularia navegação para a tela de cadastro)');
        
        // Em um projeto real, você faria:
        // window.location.href = '/cadastrar-produtos';
    });

    // Código adicional para animações ou interações pode ser adicionado aqui, se necessário.
});