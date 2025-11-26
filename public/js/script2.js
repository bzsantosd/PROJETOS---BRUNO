// Objeto que armazena os dados do Dashboard por período
// MUDAR OS DADOS AQUI É A MANEIRA MAIS FÁCIL DE EDITÁ-LOS
const dashboardData = {
    'mes-anterior': {
        newClients: '80',
        newClientsTrend: '▼ 30%', // O símbolo indica a direção (up/down)
        totalClients: '1.150',
        totalClientsTrend: '▲ 5%',
        collaborators: '50',
        productHighName: 'Whey Protein 900g Growth',
        productHighSold: '7 K',
        productHighStock: '300',
        productHighValue: '850 K',
        productLowName: 'Barra de Proteína',
        productLowStock: '5',
        flowAverage: '90',
        // Altura das barras do gráfico (para simular a variação)
        flowChartHeights: ['40px', '70px', '60px', '80px', '30px', '50px', '70px'], 
    },
    'este-mes': {
        newClients: '135',
        newClientsTrend: '▲ 70%',
        totalClients: '1.200',
        totalClientsTrend: '▲ 10%',
        collaborators: '50',
        productHighName: 'Creatina 300g Integralmedica',
        productHighSold: '10 K',
        productHighStock: '500',
        productHighValue: '1 M',
        productLowName: 'Whey Protein 900g Integralmedica',
        productLowStock: '3',
        flowAverage: '106',
        flowChartHeights: ['30px', '80px', '50px', '90px', '40px', '70px', '60px'],
    },
    'este-ano': {
        newClients: '1.500',
        newClientsTrend: '▲ 15%',
        totalClients: '1.200', 
        totalClientsTrend: '▲ 10%',
        collaborators: '50',
        productHighName: 'Pré-Treino C4',
        productHighSold: '25 K',
        productHighStock: '900',
        productHighValue: '2.5 M',
        productLowName: 'Coqueteleiras',
        productLowStock: '10',
        flowAverage: '115',
        flowChartHeights: ['70px', '90px', '80px', '100px', '60px', '85px', '75px'],
    }
    // Você pode adicionar mais períodos ou modificar estes.
};

// Mapeamento de elementos do DOM para atualização
const elements = {
    newClients: document.querySelector('.new-clients-card .main-value'),
    newClientsTrend: document.querySelector('.new-clients-card .trend'),
    totalClients: document.querySelector('.total-clients-card .main-value'),
    totalClientsTrend: document.querySelector('.total-clients-card .trend'),
    collaborators: document.querySelector('.collaborators-card .main-value'),
    productHighName: document.querySelector('.product-high-card .product-name'),
    // Note: O seletor abaixo é mais específico para o 1º valor (Vendidos)
    productHighSold: document.querySelector('.product-high-card .product-value-box:nth-child(1) .product-value-number'), 
    productHighStock: document.querySelector('.product-high-card .product-value-box:nth-child(2) .product-value-number'),
    // Note: O seletor abaixo é mais específico para o 3º valor (Valor Obtido)
    productHighValue: document.querySelector('.product-high-card .product-value-box:nth-child(3) .product-value-number'),
    productLowName: document.querySelector('.product-low-card .stock-name'),
    productLowStock: document.querySelector('.product-low-card .stock-value-number'),
    flowAverage: document.querySelector('.flow-card .flow-value'),
    flowChartPoints: document.querySelectorAll('.flow-chart .chart-data-point'),
};


// 1. Função principal para atualizar o DOM com os novos dados
function updateDashboardData(period) {
    const data = dashboardData[period];

    if (!data) {
        console.warn(`Dados não encontrados para o período: ${period}`);
        return; 
    }
    
    // --- FUNÇÕES DE ATUALIZAÇÃO REUTILIZÁVEIS ---
    const updateTrend = (element, trendString) => {
        element.textContent = trendString.substring(2).trim(); 
        element.classList.remove('up', 'down');
        element.classList.add(trendString.includes('▲') ? 'up' : 'down');
    };

    // --- ATUALIZAÇÃO DOS CARDS DE ESTATÍSTICAS ---
    elements.newClients.textContent = data.newClients;
    updateTrend(elements.newClientsTrend, data.newClientsTrend);

    elements.totalClients.textContent = data.totalClients;
    updateTrend(elements.totalClientsTrend, data.totalClientsTrend);

    elements.collaborators.textContent = data.collaborators;
    
    // --- ATUALIZAÇÃO DOS CARDS DE PRODUTOS ---
    elements.productHighName.textContent = data.productHighName;
    elements.productHighSold.textContent = data.productHighSold;
    elements.productHighStock.textContent = data.productHighStock;
    elements.productHighValue.textContent = data.productHighValue;
    
    elements.productLowName.textContent = data.productLowName;
    elements.productLowStock.textContent = data.productLowStock;
    
    // --- ATUALIZAÇÃO DO FLUXO DE ALUNOS ---
    elements.flowAverage.textContent = data.flowAverage;
    
    // ATUALIZAÇÃO DAS BARRAS DO GRÁFICO (Fluxo)
    elements.flowChartPoints.forEach((point, index) => {
        if (data.flowChartHeights[index]) {
            point.style.height = data.flowChartHeights[index];
        }
    });
}


// 2. LÓGICA DA NAVEGAÇÃO DE PERÍODO (Event Listeners)
const periodNav = document.getElementById('periodNav');
const navButtons = periodNav.querySelectorAll('.nav-button');

navButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Remove a classe 'active' de todos os botões
        navButtons.forEach(btn => btn.classList.remove('active'));

        // Adiciona a classe 'active' ao botão clicado
        button.classList.add('active');

        // Pega o período para carregar os dados
        const period = button.getAttribute('data-period');
        
        // Atualiza o dashboard com os novos dados
        updateDashboardData(period);

        console.log(`Período selecionado: ${period}`);
        // alert(`Atualizando dados para o período: ${period.toUpperCase().replace('-', ' ')}...`);
    });
});

// 3. Inicializa o dashboard com o período 'este-mes' (ativo por padrão no HTML)
document.addEventListener('DOMContentLoaded', () => {
    updateDashboardData('este-mes');
});