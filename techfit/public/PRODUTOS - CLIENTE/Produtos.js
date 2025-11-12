// produtos_cliente.js
document.addEventListener('DOMContentLoaded', () => {
    const productsGrid = document.querySelector('.products-grid');

    // Função para obter apenas produtos 'ativos'
    const getActiveProducts = () => {
        const productsJSON = localStorage.getItem('techfitProducts');
        const allProducts = productsJSON ? JSON.parse(productsJSON) : [];
        // Filtra para mostrar apenas produtos com status 'ativo'
        return allProducts.filter(p => p.status === 'ativo');
    };

    // Função para criar o HTML de um cartão de produto
    const createProductCard = (product) => {
        // Função para formatar o preço (opcional, mas bom para a visualização)
        const formatPrice = (priceStr) => {
            // Remove 'R$', espaços e substitui vírgula por ponto para conversão
            const numericPrice = priceStr.replace('R$', '').replace(/\s/g, '').replace(',', '.');
            const price = parseFloat(numericPrice);
            return isNaN(price) ? product['preco-unitario'] : `R$ ${price.toFixed(2).replace('.', ',')}`;
        };

        const card = document.createElement('div');
        card.classList.add('product-card');

        // Note: 'src="IMAGEM/placeholder.jpg"' é um placeholder, você precisaria de uma imagem real por produto.
        card.innerHTML = `
            <img src="IMAGEM/placeholder.jpg" alt="${product['nome-produto']}" class="product-image" style="width: 100%; height: auto;">
            <div class="product-details">
                <h3 class="product-title">${product['nome-produto']}<br>(${product.marca || 'Marca Indefinida'})</h3>
                <p class="product-description">${product['descricao-produto'] || 'Sem descrição.'}</p>
                <p class="product-category">Categoria: ${product.categoria || 'Geral'}</p>
                <p class="product-stock">Em Estoque: ${product.quantidade || 0}</p>
            </div>
            <div class="product-price-box">
                <p class="product-price">${formatPrice(product['preco-unitario'])}</p>
                <button class="action-button add-to-cart" data-code="${product.codigo}">Adicionar ao Carrinho</button>
            </div>
        `;
        return card;
    };

    // Função principal de renderização
    const renderProducts = () => {
        const activeProducts = getActiveProducts();
        productsGrid.innerHTML = ''; // Limpa o grid existente

        if (activeProducts.length === 0) {
            productsGrid.innerHTML = '<p style="grid-column: 1 / -1; text-align: center; padding: 20px;">Nenhum produto ATIVO cadastrado no momento.</p>';
            return;
        }

        activeProducts.forEach(product => {
            productsGrid.appendChild(createProductCard(product));
        });
    };
    
    // Inicializa a renderização
    renderProducts();

    // Exemplo de manipulação do botão "Adicionar ao Carrinho"
    productsGrid.addEventListener('click', (e) => {
        if (e.target.classList.contains('add-to-cart')) {
            const productCode = e.target.getAttribute('data-code');
            alert(`Produto código ${productCode} adicionado ao carrinho! (Simulação)`);
        }
    });
});