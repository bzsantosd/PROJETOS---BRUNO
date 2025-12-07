// carrinho.js - Lógica do Carrinho de Compras

document.addEventListener('DOMContentLoaded', () => {
    // Referências aos elementos do DOM
    const cartList = document.getElementById('cart-items-list');
    const subtotalValue = document.getElementById('subtotal-value');
    const totalValue = document.getElementById('total-value');
    const shippingValue = document.getElementById('shipping-value');
    const checkoutBtn = document.querySelector('.checkout-btn');
    const FIXED_SHIPPING = 15.00; // Frete fixo R$15,00

    // --- FUNÇÕES DE UTILIDADE ---

    // Obtém o carrinho do localStorage
    const getCart = () => {
        const cartJSON = localStorage.getItem('techfitCart');
        return cartJSON ? JSON.parse(cartJSON) : [];
    };

    // Salva o carrinho no localStorage e renderiza novamente
    const saveCart = (cart) => {
        localStorage.setItem('techfitCart', JSON.stringify(cart));
        renderCart(); // Recarrega o carrinho toda vez que ele é salvo
        updateCartCounter(); 
    };

    // Formata o valor numérico para o padrão monetário brasileiro (R$ 00,00)
    const formatPrice = (price) => {
        return `R$ ${price.toFixed(2).replace('.', ',')}`;
    };

    // Atualiza o contador de itens no cabeçalho
    const updateCartCounter = () => {
        const cart = getCart();
        const totalItems = cart.reduce((sum, item) => sum + item.quantidade, 0);
        const cartCounter = document.getElementById('cart-counter');
        if (cartCounter) {
            cartCounter.textContent = totalItems;
        }
    };

    // Calcula Subtotal e Total
    const calculateSummary = (cart) => {
        let subtotal = 0;
        cart.forEach(item => {
            // Limpa e converte a string de preço para número
            const priceString = item.preco.replace('R$', '').trim().replace(',', '.');
            const price = parseFloat(priceString);
            if (!isNaN(price)) {
                subtotal += price * item.quantidade;
            }
        });
        
        // Frete só é cobrado se houver itens no carrinho
        const currentShipping = cart.length > 0 ? FIXED_SHIPPING : 0.00;
        const total = subtotal + currentShipping;
        
        // Atualiza os valores no HTML
        subtotalValue.textContent = formatPrice(subtotal);
        totalValue.textContent = formatPrice(total);
        shippingValue.textContent = formatPrice(currentShipping);
        
        return { subtotal, total, currentShipping };
    };

    // Renderiza o HTML dos itens do carrinho
    const renderCart = () => {
        const cart = getCart();
        cartList.innerHTML = ''; // Limpa a lista existente

        if (cart.length === 0) {
            cartList.innerHTML = '<p class="empty-cart-message">Seu carrinho está vazio. Que tal adicionar alguns produtos?</p>';
            calculateSummary(cart); // Atualiza os valores para 0
            checkoutBtn.disabled = true;
            return;
        }
        
        checkoutBtn.disabled = false;

        cart.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item');
            
            // Limpa e converte o preço unitário
            const priceString = item.preco.replace('R$', '').trim().replace(',', '.');
            const unitPrice = parseFloat(priceString);
            const itemTotal = unitPrice * item.quantidade;
            
            // ATENÇÃO: Adicionado o span com o código do produto para a funcionalidade de remoção.
            itemElement.innerHTML = `
                <div class="item-info">
                    <h4 class="item-name">${item.nome}</h4>
                    <p class="item-price-unit">${item.preco} por unidade</p>
                </div>
                <div class="item-quantity-control">
                    <button class="qty-btn remove-one" data-code="${item.codigo}">-</button>
                    <span class="item-quantity">${item.quantidade}</span>
                    <button class="qty-btn add-one" data-code="${item.codigo}">+</button>
                </div>
                <div class="item-total">
                    <span class="item-total-price">${formatPrice(itemTotal)}</span>
                </div>
                <button class="remove-item-btn" data-code="${item.codigo}">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            cartList.appendChild(itemElement);
        });
        
        calculateSummary(cart);
    };

    // Lida com as ações de Adicionar/Remover/Ajustar Quantidade
    const handleCartAction = (e) => {
        // Encontra o botão mais próximo que foi clicado
        const target = e.target.closest('button');
        if (!target) return;

        const productCode = target.getAttribute('data-code');
        if (!productCode) return;

        const cart = getCart();
        const itemIndex = cart.findIndex(item => item.codigo === productCode);

        if (itemIndex === -1) return;

        if (target.classList.contains('add-one')) {
            cart[itemIndex].quantidade++;
        } else if (target.classList.contains('remove-one')) {
            if (cart[itemIndex].quantidade > 1) {
                cart[itemIndex].quantidade--;
            } else {
                // Remove o item se a quantidade for 1
                cart.splice(itemIndex, 1);
            }
        } else if (target.classList.contains('remove-item-btn')) {
            // Remove o item completamente
            cart.splice(itemIndex, 1);
        }

        saveCart(cart); // Salva e renderiza novamente
    };
    
    // --- LÓGICA DE CHECKOUT (Finalizar Compra) ---
    checkoutBtn.addEventListener('click', () => {
        const cart = getCart();
        if (cart.length > 0) {
            const { subtotal, total, currentShipping } = calculateSummary(cart);

            // Opcional: Salva o resumo final no localStorage para uso na página de checkout
            localStorage.setItem('finalOrderSummary', JSON.stringify({
                subtotal: subtotal,
                shipping: currentShipping,
                total: total,
                items: cart // Inclui os itens para visualização na tela de checkout
            }));

            // Redireciona para a página de finalização da compra
            window.location.href = 'finalizar_compra.html';
        } else {
            alert('Seu carrinho está vazio. Adicione produtos antes de finalizar a compra.');
        }
    });

    // Inicia a renderização do carrinho e adiciona o listener de ações
    renderCart();
    cartList.addEventListener('click', handleCartAction);
    updateCartCounter();
});