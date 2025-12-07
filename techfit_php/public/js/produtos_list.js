// produtos_list.js - Lógica para o carrinho de compras

document.addEventListener('DOMContentLoaded', () => {
    const productsGrid = document.querySelector('.products-grid');

    // 1. MAPEAMENTO DE PRODUTOS
    const productDataMap = {
        'C001': { 'nome-produto': 'Conjunto Masculino', 'preco-unitario': 'R$ 69,90' }, //
        'C002': { 'nome-produto': 'Conjunto Feminino', 'preco-unitario': 'R$ 69,90' }, //
        'S001': { 'nome-produto': 'Creatina 500g', 'preco-unitario': 'R$ 34,90' }, //
        'S002': { 'nome-produto': 'Whey', 'preco-unitario': 'R$ 39,90' }, //
        'S003': { 'nome-produto': 'Suplementos', 'preco-unitario': 'R$ 34,90' } //
        // Adicione outros produtos se necessário aqui
    };

    // --- FUNÇÕES DE CARRINHO ---

    // Obtém o carrinho do localStorage ou retorna um array vazio
    const getCart = () => {
        const cartJSON = localStorage.getItem('techfitCart'); //
        return cartJSON ? JSON.parse(cartJSON) : []; //
    };

    // Salva o carrinho no localStorage e chama a atualização do contador
    const saveCart = (cart) => {
        localStorage.setItem('techfitCart', JSON.stringify(cart)); //
        updateCartCount(); //
    };

    // Adiciona um produto ao carrinho
    const addToCart = (productCode, product) => {
        const cart = getCart(); //
        const existingItemIndex = cart.findIndex(item => item.codigo === productCode); //

        if (existingItemIndex > -1) {
            // Se o produto já existe, incrementa a quantidade
            cart[existingItemIndex].quantidade++; //
        } else {
            // Se não existe, adiciona o novo item com quantidade 1
            cart.push({
                codigo: productCode, //
                nome: product['nome-produto'], //
                preco: product['preco-unitario'], //
                quantidade: 1 //
            });
        }
        saveCart(cart); //
        
        // CORREÇÃO APLICADA AQUI:
        // 1. Removemos o alert()
        // 2. Redirecionamos para a página do carrinho
        window.location.href = '/techfit_php/public/carrinho.html'; // Redireciona para a página do carrinho
    };
    
    // Atualiza o contador de itens no cabeçalho (#cart-counter)
    const updateCartCount = () => {
        const cart = getCart(); //
        // Soma a quantidade de todos os itens no carrinho
        const totalItems = cart.reduce((sum, item) => sum + item.quantidade, 0); //
        
        const cartBadge = document.getElementById('cart-counter'); //
        if (cartBadge) {
            // Atualiza o span com o ID 'cart-counter'
            cartBadge.textContent = totalItems; //
        }
    };

    // --- MANIPULAÇÃO DE EVENTOS ---

    if (productsGrid) {
        // Adiciona o listener para todos os botões no grid
        productsGrid.addEventListener('click', (e) => {
            // Verifica se o clique foi em um botão com a classe 'add-to-cart'
            if (e.target.classList.contains('add-to-cart')) { //
                const productCode = e.target.getAttribute('data-code'); //
                const productToAdd = productDataMap[productCode]; //

                if (productToAdd) {
                    addToCart(productCode, productToAdd); //
                } else {
                    alert('Erro: Produto não encontrado. Verifique o código no HTML.'); //
                }
            }
        });
    }
    
    // Inicializa o contador de carrinho quando a página carrega
    updateCartCount(); //
});