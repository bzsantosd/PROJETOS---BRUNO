// script.js

// 1. DADOS DE EXEMPLO (Simulação de um Banco de Dados)
// Em um sistema real, estes dados viriam de uma API ou do servidor.
const dadosDoCliente = {
    'email.cliente@exemplo.com': {
        nome: 'Maria da Silva',
        telefone: '(11) 98765-4321',
        pedidos: [
            { id: '12345', valor: 150.00, status: 'Entregue' },
            { id: '12344', valor: 99.90, status: 'Em Separação' },
            { id: '12343', valor: 25.50, status: 'Cancelado' }
        ]
    },
    'outro.cliente@exemplo.com': {
        nome: 'João Oliveira',
        telefone: '(21) 99999-0000',
        pedidos: [
            { id: '10001', valor: 500.00, status: 'Aprovado' }
        ]
    }
    // Adicione mais perfis se quiser testar a mudança
};

// 2. VARIÁVEL QUE SIMULA O CLIENTE LOGADO
// Aqui você define qual perfil será carregado.
const emailDoClienteLogado = 'email.cliente@exemplo.com'; // Mude este email para testar outro perfil
const clienteLogado = dadosDoCliente[emailDoClienteLogado];


/**
 * Função para preencher a seção "Meus Dados Pessoais"
 */
function carregarDadosPessoais() {
    if (!clienteLogado) {
        console.error("Cliente não encontrado.");
        return;
    }

    // Preenche os elementos HTML com os IDs correspondentes
    document.getElementById('nome-cliente').textContent = clienteLogado.nome;
    document.getElementById('email-cliente').textContent = emailDoClienteLogado;
    document.getElementById('tel-cliente').textContent = clienteLogado.telefone;

    // Atualiza o título da página e o cabeçalho
    document.title = `Meu Perfil - ${clienteLogado.nome.split(' ')[0]}`;
    document.querySelector('header h1').innerHTML = `Bem-vindo(a), <strong>${clienteLogado.nome.split(' ')[0]}</strong>!`;
}


/**
 * Função para criar a lista de pedidos no HTML
 */
function carregarHistoricoDePedidos() {
    if (!clienteLogado || !clienteLogado.pedidos) {
        return;
    }

    const listaPedidos = document.querySelector('#pedidos ul');
    listaPedidos.innerHTML = ''; // Limpa a lista existente

    clienteLogado.pedidos.forEach(pedido => {
        const li = document.createElement('li');
        
        // Formata o valor para Real (R$)
        const valorFormatado = pedido.valor.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });

        li.innerHTML = `Pedido **#${pedido.id}** - ${valorFormatado} - **${pedido.status}**`;

        // Adiciona um estilo básico de cor para o status
        if (pedido.status === 'Entregue') {
            li.style.color = '#28a745'; // Verde
        } else if (pedido.status === 'Em Separação') {
            li.style.color = '#ffc107'; // Amarelo
        } else if (pedido.status === 'Cancelado') {
            li.style.color = '#dc3545'; // Vermelho
        }


        listaPedidos.appendChild(li);
    });
}


// 3. EVENTO DE CARREGAMENTO: Garante que as funções só rodem depois que o HTML estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    carregarDadosPessoais();
    carregarHistoricoDePedidos();
});