/**
 * cliente.js
 * Script para funcionalidades da página de perfil do cliente.
 */

document.addEventListener('DOMContentLoaded', function() {

    // --- Funções de utilidade do Carrinho (Copiadas de carrinho.js) ---
    const getCart = () => {
        // Lê o carrinho do localStorage. 'techfitCart' é a chave usada em carrinho.js.
        const cartJSON = localStorage.getItem('techfitCart');
        return cartJSON ? JSON.parse(cartJSON) : [];
    };
    
    const calculateItemCount = (cart) => {
        let count = 0;
        // Soma as quantidades de todos os itens no carrinho
        cart.forEach(item => {
            count += item.quantidade;
        });
        return count;
    };


    // --- 1. Inicialização do Contador do Carrinho ---
    
    const cart = getCart();
    const itemCount = calculateItemCount(cart);
    
    const cartCounter = document.getElementById('cart-counter');

    if (cartCounter) {
        // Atualiza o texto do contador com o número real de itens
        cartCounter.textContent = itemCount.toString();
        
        // Exibe o contador apenas se houver itens
        if (itemCount > 0) {
            cartCounter.style.display = 'block'; 
        } else {
            cartCounter.style.display = 'none'; // Oculta se estiver vazio
        }
    }


    // --- 2. Destaque do Item de Navegação Ativo ---
    
    // Este bloco garante que o link da página atual esteja ativo, 
    // com base no href do link.
    const navItems = document.querySelectorAll('.nav-item a');
    // Obtém o nome do arquivo atual (e.g., 'cliente.html')
    const currentPagePath = window.location.pathname.split('/').pop() || 'cliente.html'; 

    navItems.forEach(item => {
        const linkPath = item.getAttribute('href').split('/').pop();
        const parentLi = item.parentElement;

        // Garante que apenas o link correto tenha a classe 'active'
        if (linkPath === currentPagePath) {
            parentLi.classList.add('active');
        } else {
             parentLi.classList.remove('active');
        }
    });

    // --- 3. Funcionalidade básica dos botões de Edição ---
    
    const editButtons = document.querySelectorAll('.editar-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const section = this.closest('.perfil-secao').querySelector('h2').textContent;
            alert(`Implementar aqui a lógica para editar: "${section}"`);
        });
    });
});