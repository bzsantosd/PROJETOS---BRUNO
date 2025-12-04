// produtos_list.js - Lógica Principal para Produtos e Carrinho

document.addEventListener('DOMContentLoaded', () => {
    const productsGrid = document.querySelector('.products-grid');

    // 1. DADOS DE PRODUTOS (Simulação de um banco de dados/API)
    const productData = [
        { codigo: 'C001', 'nome-produto': 'Conjunto Masculino', 'preco-unitario': 'R$ 69,90', status: 'ativo', 'descricao-produto': 'O Kit Camiseta e Shorts de Performance, em preto, oferece tecnologia de tecido para liberdade de movimento e secagem rápida.' },
        { codigo: 'C002', 'nome-produto': 'Conjunto Feminino', 'preco-unitario': 'R$ 69,90', status: 'ativo', 'descricao-produto': 'Top cropped regata e um shorts-saia com legging integrada, oferecendo estilo e funcionalidade.' },
        { codigo: 'S001', 'nome-produto': 'Creatina 500g', 'preco-unitario': 'R$ 34,90', status: 'ativo', 'descricao-produto': 'Potencialize seus treinos com nossa creatina em pó, sabor natural.' },
        { codigo: 'S002', 'nome-produto': 'Whey', 'preco-unitario': 'R$ 39,90', status: 'ativo', 'descricao-produto': 'Potencialize seus treinos com nosso Whey sabor Morango.' },
        { codigo: 'S003', 'nome-produto': 'Suplementos', 'preco-unitario': 'R$ 34,90', status: 'ativo', 'descricao-produto': 'Potencialize seus treinos com nosso Whey sabor Morango.' },
        // Adicione mais produtos conforme necessário
    ];

    // --- FUNÇÕES DE UTILIDADE E CARRINHO ---

    // Obtém o carrinho do localStorage
    const getCart = () => {
        const cartJSON = localStorage.getItem('techfitCart');
        return cartJSON ? JSON.parse(cartJSON) : [];
    };

    // Salva o carrinho no localStorage e atualiza o contador
    const saveCart = (cart) => {
        localStorage.setItem('techfitCart', JSON.stringify(cart));
        updateCartCount();
    };

    // Formata o preço para exibição (ex: R$ 69,90)
    const formatPrice = (priceStr) => {
        const numericPrice = priceStr.replace('R$', '').replace(/\s/g, '').replace(',', '.');
        const price = parseFloat(numericPrice);
        return isNaN(price) ? priceStr : `R$ ${price.toFixed(2).replace('.', ',')}`;
    };

    // Encontra apenas produtos 'ativos' (neste caso, todos na lista simulada)
    const getActiveProducts = () => {
        // Em um projeto real, você faria uma requisição AJAX/Fetch aqui.
        // Aqui, filtramos a lista simulada (todos são 'ativo' por padrão)
        return productData.filter(p => p.status === 'ativo');
    };

    // Adiciona um produto ao carrinho
    const addToCart = (productCode, product) => {
        const cart = getCart();
        const existingItemIndex = cart.findIndex(item => item.codigo === productCode);

        if (existingItemIndex > -1) {
            cart[existingItemIndex].quantidade++;
        } else {
            cart.push({
                codigo: productCode,
                nome: product['nome-produto'],
                preco: product['preco-unitario'],
                quantidade: 1
            });
        }
        saveCart(cart);
        alert(`"${product['nome-produto']}" adicionado ao carrinho!`);
    };
    
    // Atualiza o contador de itens no cabeçalho
    const updateCartCount = () => {
        const cart = getCart();
        // Soma a quantidade de todos os itens no carrinho
        const totalItems = cart.reduce((sum, item) => sum + item.quantidade, 0);
        
        const cartBadge = document.getElementById('cart-counter');
        if (cartBadge) {
            // Atualiza o span com o ID 'cart-counter'
            cartBadge.textContent = totalItems;
        }
    };

    // --- FUNÇÕES DE RENDERIZAÇÃO ---

    // Cria o HTML de um card de produto
    const createProductCard = (product) => {
        const card = document.createElement('div');
        card.classList.add('product-card');

        // Note: As URLs de imagem são baseadas nos links do seu HTML para simulação
        let imageUrl = '';
        if (product.codigo === 'C001') {
            imageUrl = 'https://github.com/bzsantosd/PROJETOS---BRUNO/blob/main/IMAGENS/01.jpg?raw=true';
        } else if (product.codigo === 'C002') {
            imageUrl = 'https://github.com/bzsantosd/PROJETOS---BRUNO/blob/main/IMAGENS/02.jpg?raw=true';
        } else if (product.codigo === 'S001') {
            imageUrl = 'https://github.com/bzsantosd/PROJETOS---BRUNO/blob/main/IMAGENS/15.jpg?raw=true';
        } else if (product.codigo === 'S002') {
            imageUrl = 'https://github.com/bzsantosd/PROJETOS---BRUNO/blob/main/IMAGENS/17.jpg?raw=true';
        } else if (product.codigo === 'S003') {
            imageUrl = 'https://github.com/bzsantosd/PROJETOS---BRUNO/blob/main/IMAGENS/suplemento.png?raw=true';
        } else {
            imageUrl = 'IMAGEM/placeholder.jpg';
        }
        
        card.innerHTML = `
            <img src="${imageUrl}" alt="${product['nome-produto']}" class="product-image">
            <div class="product-details">
                <h3 class="product-title">${product['nome-produto']}</h3>
                <p class="product-description">${product['descricao-produto'] || 'Sem descrição.'}</p>
            </div>
            <div class="product-price-box">
                <p class="product-price">${formatPrice(product['preco-unitario'])}</p>
                <button class="action-button add-to-cart" data-code="${product.codigo}">Colocar no Carrinho</button>
            </div>
        `;
        return card;
    };

    // Renderiza todos os produtos ativos no grid
    const renderProducts = () => {
        const activeProducts = getActiveProducts();
        if (!productsGrid) return; 

        productsGrid.innerHTML = ''; 

        if (activeProducts.length === 0) {
            productsGrid.innerHTML = '<p style="grid-column: 1 / -1; text-align: center; padding: 20px;">Nenhum produto ATIVO cadastrado no momento.</p>';
            return;
        }

        activeProducts.forEach(product => {
            productsGrid.appendChild(createProductCard(product));
        });
    };
    
    // --- MANIPULAÇÃO DE EVENTOS ---

    if (productsGrid) {
        productsGrid.addEventListener('click', (e) => {
            if (e.target.classList.contains('add-to-cart')) {
                const productCode = e.target.getAttribute('data-code');
                const activeProducts = getActiveProducts();
                
                // Encontra o produto completo para adicionar ao carrinho
                const productToAdd = activeProducts.find(p => p.codigo === productCode);
                
                if (productToAdd) {
                    addToCart(productCode, productToAdd);
                } else {
                     alert('Erro: Produto não encontrado para adicionar ao carrinho.');
                }
            }
        });
    }

    // Inicialização
    renderProducts();
    updateCartCount(); // Inicia o contador assim que a página carrega
});