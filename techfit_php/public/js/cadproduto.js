document.addEventListener('DOMContentLoaded', () => {
    // Seletores dos elementos
    const form = document.querySelector('.cadastro-form');
    const notificacao = document.getElementById('notificacao');

    // Inicializa a lista de produtos (puxa do localStorage ou usa uma lista vazia)
    let produtos = JSON.parse(localStorage.getItem('produtosAcademia')) || [];

    // --- FUNÇÃO PARA EXIBIR A NOTIFICAÇÃO ---
    function exibirNotificacao() {
        notificacao.textContent = "PRODUTO CADASTRADO COM SUCESSO"; 
        notificacao.classList.add('show'); 
        
        // Define um timer para remover a notificação após 3 segundos
        setTimeout(() => {
            notificacao.classList.remove('show');
        }, 3000); 
    }

    // --- FUNÇÃO DE CADASTRO (Ao Submeter o Formulário) ---
    form.addEventListener('submit', function(event) {
        // ESSENCIAL: Impede o envio do formulário ao servidor e a recarga da página
        event.preventDefault(); 

        // 1. Coleta os dados do formulário
        const novoProduto = {
            id: Date.now(), 
            nome: document.getElementById('nome').value,
            descricao: document.getElementById('descricao').value,
            categoria: document.getElementById('categoria').value,
            // Garante que o preço tenha duas casas decimais
            preco: parseFloat(document.getElementById('preco').value).toFixed(2), 
            quantidade: parseInt(document.getElementById('quantidade').value)
        };

        // 2. Adiciona o novo produto à lista e salva no localStorage
        produtos.push(novoProduto);
        localStorage.setItem('produtosAcademia', JSON.stringify(produtos));

        // 3. Limpa o formulário
        form.reset();

        // 4. Exibe a notificação de sucesso
        exibirNotificacao(`Produto "${novoProduto.nome}" cadastrado com sucesso!`);
    });
    
    // As funções e chamadas para renderizar a lista foram removidas, 
    // pois a lista será exibida em 'produtoscadastrados.html'.
});