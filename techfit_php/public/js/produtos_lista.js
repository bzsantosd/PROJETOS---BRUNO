document.addEventListener('DOMContentLoaded', () => {
    // 1. Puxa a lista de produtos do localStorage
    const produtos = JSON.parse(localStorage.getItem('produtosAcademia')) || [];
    
    // 2. Seleciona o container onde os produtos serão injetados
    const productsGrid = document.querySelector('.products-grid');

    if (!productsGrid) {
        console.error("Container '.products-grid' não encontrado.");
        return;
    }
    
    // 3. Limpa os produtos estáticos (se houver, no HTML corrigido abaixo vamos removê-los)
    productsGrid.innerHTML = ''; 

    if (produtos.length === 0) {
        productsGrid.innerHTML = '<p class="aviso-vazio">Nenhum produto cadastrado dinamicamente ainda.</p>';
        // Se houver produtos estáticos que você quer manter, insira a renderização deles aqui ou não limpe o innerHTML.
        return;
    }

    // 4. Itera sobre a lista de produtos e cria o HTML no formato de "card"
    produtos.forEach(produto => {
        // Usa a mesma estrutura de produto-card do Produtos.html para manter a consistência visual
        const cardHTML = `
            <div class="product-card produto-dinamico">
                <div class="badge-cadastro">NOVO PRODUTO CADASTRADO</div>
                
                <img src="https://via.placeholder.com/300x200?text=TechFit+Produto" alt="${produto.nome}" class="product-image">
                
                <div class="product-details">
                    <h3 class="product-title">${produto.nome} (${produto.categoria.toUpperCase()})</h3>
                    <p class="product-description">${produto.descricao || 'Descrição não fornecida.'}</p>
                </div>
                
                <div class="product-price-box">
                    <p class="product-price">R$${produto.preco.replace('.', ',')}</p>
                    <button class="action-button add-to-cart" disabled>Item Cadastrado</button>
                </div>
            </div>
        `;
        
        productsGrid.innerHTML += cardHTML;
    });
});