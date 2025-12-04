// carrinho.js
document.addEventListener('DOMContentLoaded', () => {
    const cartList = document.getElementById('cart-items-list');
    const subtotalValue = document.getElementById('subtotal-value');
    const totalValue = document.getElementById('total-value');
    const shippingValue = document.getElementById('shipping-value');
    const FIXED_SHIPPING = 15.00; // Frete fixo R$15,00

    // Funções de utilidade
    const getCart = () => {
        const cartJSON = localStorage.getItem('techfitCart');
        return cartJSON ? JSON.parse(cartJSON) : [];
    };

    const saveCart = (cart) => {
        localStorage.setItem('techfitCart', JSON.stringify(cart));
        renderCart(); // Recarrega o carrinho toda vez que ele é salvo
    };

    const formatPrice = (price) => {
        return `R$ ${price.toFixed(2).replace('.', ',')}`;
    };

    // --- FUNÇÕES DE RENDERIZAÇÃO E CÁLCULO ---

    const createCartItemElement = (item) => {
        const card = document.createElement('div');
        card.classList.add('cart-item');
        card.setAttribute('data-code', item.codigo);

        // Converte o preço unitário para número (removendo "R$ " e trocando vírgula por ponto)
        const numericPrice = parseFloat(item.preco.replace('R$', '').replace(',', '.').trim());
        const totalPriceItem = numericPrice * item.quantidade;

        card.innerHTML = `
            <img src="IMAGEM/placeholder.jpg" alt="${item.nome}" class="item-image">
            <div class="item-details">
                <h4 class="item-name">${item.nome}</h4>
                <p class="item-price">${formatPrice(totalPriceItem)}</p>
            </div>
            <div class="item-quantity-control">
                <button class="qty-btn remove-one" data-code="${item.codigo}">-</button>
                <span class="item-quantity">${item.quantidade}</span>
                <button class="qty-btn add-one" data-code="${item.codigo}">+</button>
            </div>
            <button class="remove-item-btn" data-code="${item.codigo}">Remover</button>
        `;
        return card;
    };

    const calculateTotals = (cart) => {
        let subtotal = 0;

        cart.forEach(item => {
            const numericPrice = parseFloat(item.preco.replace('R$', '').replace(',', '.').trim());
            subtotal += numericPrice * item.quantidade;
        });

        // O frete só é cobrado se houver itens no carrinho
        const shipping = subtotal > 0 ? FIXED_SHIPPING : 0.00;
        const total = subtotal + shipping;

        // Atualiza o DOM
        subtotalValue.textContent = formatPrice(subtotal);
        shippingValue.textContent = formatPrice(shipping);
        totalValue.textContent = formatPrice(total);
    };

    const renderCart = () => {
        const cart = getCart();
        cartList.innerHTML = ''; // Limpa a lista existente

        if (cart.length === 0) {
            cartList.innerHTML = '<p class="empty-cart-message">Seu carrinho está vazio. Visite a página de <a href="/techfit_php/public/Produtos.html" style="color: var(--primary-color);">Produtos</a> para adicionar itens!</p>';
            totalValue.textContent = formatPrice(0);
        } else {
            cart.forEach(item => {
                cartList.appendChild(createCartItemElement(item));
            });
        }
        
        calculateTotals(cart);
    };
    
    // --- MANIPULAÇÃO DE EVENTOS DO CARRINHO ---

    const handleCartAction = (e) => {
        const target = e.target;
        if (!target.classList.contains('qty-btn') && !target.classList.contains('remove-item-btn')) {
            return;
        }

        const productCode = target.getAttribute('data-code');
        let cart = getCart();
        const itemIndex = cart.findIndex(item => item.codigo === productCode);

        if (itemIndex === -1) return;

        if (target.classList.contains('add-one')) {
            // Aumenta a quantidade
            cart[itemIndex].quantidade++;
        } else if (target.classList.contains('remove-one')) {
            // Diminui a quantidade, remove se chegar a 0
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

        saveCart(cart);
    };
    
    // Inicia a renderização do carrinho e adiciona o listener de ações
    renderCart();
    cartList.addEventListener('click', handleCartAction);
    
    // Listener para o botão Finalizar Compra (apenas simulação)
    document.querySelector('.checkout-btn').addEventListener('click', () => {
        const cart = getCart();
        if (cart.length > 0) {
            alert('Simulação de Compra Finalizada! Redirecionando para o pagamento...');
            // Aqui você adicionaria a lógica de limpeza do carrinho e redirecionamento
            // saveCart([]); // Descomente para limpar o carrinho após a compra simulada
        } else {
            alert('Seu carrinho está vazio! Adicione produtos para prosseguir.');
        }
    });

});