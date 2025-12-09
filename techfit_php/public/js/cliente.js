/**
 * cliente.js
 * Script para funcionalidades da página de perfil do cliente e carregamento de dados.
 */

document.addEventListener('DOMContentLoaded', function() {

    // ==========================================================
    // --- NOVO: FUNÇÃO PARA CARREGAR DADOS DO CLIENTE DO LOCALSTORAGE ---
    // ==========================================================
    const loadClientData = () => {
        // Busca os dados salvos pelo processo de cadastro/login
        const userDataString = localStorage.getItem('currentUserData');
        
        if (userDataString) {
            const userData = JSON.parse(userDataString);
            
            // 1. Injeta os dados nas Informações Pessoais
            document.getElementById('main-title').textContent = `Bem-vindo(a), ${userData.nome || 'Cliente'}!`;
            document.getElementById('nome').textContent = userData.nome || 'Não informado';
            document.getElementById('email').textContent = userData.email || 'Não informado';
            
            // ATENÇÃO: Os campos 'telefone' e 'endereco' não estão no formulário 'usuario.php' 
            // que você enviou. Eles podem ser vazios.
            document.getElementById('telefone').textContent = userData.telefone || 'N/A';
            document.getElementById('endereco').textContent = userData.endereco || 'N/A';
            
            // 2. Simula e Injeta os Dados de Pedidos
            // Como o histórico de pedidos não está no localStorage, usaremos uma simulação
            const pedidosDados = [
                { id: '1027', valor: '399,00', status: 'Pagamento Confirmado' },
                { id: '1026', valor: '89,50', status: 'Em Transporte' },
                { id: '1025', valor: '249,90', status: 'Entregue' }
            ];

            const listaPedidos = document.getElementById('lista-pedidos');
            listaPedidos.innerHTML = ''; // Limpa o "Carregando..."
            
            pedidosDados.forEach(pedido => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `<b>Pedido #${pedido.id}</b> - R$ ${pedido.valor} - <b>Status:</b> ${pedido.status}`;
                listaPedidos.appendChild(listItem);
            });
            
        } else {
            // Caso não haja dados no localStorage (cliente não logado)
            document.getElementById('main-title').textContent = 'Bem-vindo(a), Visitante!';
            document.getElementById('nome').textContent = 'Usuário não logado.';
            document.getElementById('email').textContent = 'Faça login para ver seus dados.';
        }
    };
    
    // Chama a função de carregamento
    loadClientData();
    // ==========================================================
    // --- FIM DA NOVA FUNÇÃO ---
    // ==========================================================


    // --- Funções de utilidade do Carrinho (Mantidas) ---
    const getCart = () => {
        const cartJSON = localStorage.getItem('techfitCart');
        return cartJSON ? JSON.parse(cartJSON) : [];
    };
    
    const calculateItemCount = (cart) => {
        let count = 0;
        cart.forEach(item => {
            count += item.quantidade;
        });
        return count;
    };


    // --- 1. Inicialização do Contador do Carrinho (Mantida) ---
    
    const cart = getCart();
    const itemCount = calculateItemCount(cart);
    
    const cartCounter = document.getElementById('cart-counter');

    if (cartCounter) {
        cartCounter.textContent = itemCount.toString();
        
        if (itemCount > 0) {
            cartCounter.style.display = 'block'; 
        } else {
            cartCounter.style.display = 'none';
        }
    }


    // --- 2. Destaque do Item de Navegação Ativo (Mantido) ---
    
    const navItems = document.querySelectorAll('.nav-item a');
    // Corrigido para buscar .php
    const currentPagePath = window.location.pathname.split('/').pop() || 'cliente.php'; 

    navItems.forEach(item => {
        const linkPath = item.getAttribute('href').split('/').pop();
        const parentLi = item.parentElement;

        if (linkPath === currentPagePath) {
            parentLi.classList.add('active');
        } else {
             parentLi.classList.remove('active');
        }
    });

    // --- 3. Funcionalidade básica dos botões de Edição (Mantida) ---
    
    const editButtons = document.querySelectorAll('.editar-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const section = this.closest('.perfil-secao').querySelector('h2').textContent;
            alert(`Implementar aqui a lógica para editar: "${section}"`);
        });
    });
});