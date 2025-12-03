document.addEventListener('DOMContentLoaded', () => {
    // IMPORTANTE: Seleciona o container pelo ID 'lista-produtos'
    const listaProdutosContainer = document.getElementById('lista-produtos');

    if (!listaProdutosContainer) {
        console.error("Elemento 'lista-produtos' não encontrado. Verifique se o ID está correto em produtoscadastrados.html");
        return;
    }

    // Puxa a lista de produtos do localStorage
    let produtos = JSON.parse(localStorage.getItem('produtosAcademia')) || [];

    // --- FUNÇÃO DE EXIBIÇÃO NA NOVA PÁGINA ---
    function renderizarProdutosCadastrados() {

        listaProdutosContainer.innerHTML = ''; 

        // 1. Verifica se há produtos salvos
        if (produtos.length === 0) {
            listaProdutosContainer.innerHTML = '<p class="aviso-vazio">Nenhum produto cadastrado ainda. Use a página de Cadastro de Produtos para adicionar itens.</p>';
            return;
        }

        // 2. Cria a estrutura de cabeçalho (usa classes do cadproduto.css)
        const headerHTML = `
            <div class="produto-item header">
                <span class="col-nome">Nome</span>
                <span class="col-cat">Categoria</span>
                <span class="col-preco">Preço (R$)</span>
                <span class="col-qtd">Qtd.</span>
            </div>
        `;
        listaProdutosContainer.innerHTML += headerHTML;

        // 3. Itera sobre a lista de produtos e cria o HTML para cada item
        produtos.forEach(produto => {
            const produtoHTML = `
                <div class="produto-item">
                    <span class="col-nome">${produto.nome}</span>
                    <span class="col-cat">${produto.categoria}</span>
                    <span class="col-preco">R$ ${produto.preco ? produto.preco.replace('.', ',') : '0,00'}</span> 
                    <span class="col-qtd">${produto.quantidade}</span>
                </div>
            `;
            listaProdutosContainer.innerHTML += produtoHTML;
        });
    }

    // Chama a função para exibir os produtos ao carregar a página
    renderizarProdutosCadastrados();
});