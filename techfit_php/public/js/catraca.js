const openModalBtn = document.getElementById('open-catraca-modal');
    const closeModalBtn = document.getElementById('close-catraca-modal');
    const modalOverlay = document.getElementById('catraca-modal-overlay');
    const catracaText = modalOverlay.querySelector('.catraca-simulation p');
    const progressBar = modalOverlay.querySelector('.progress-bar-placeholder');
    const approveBtn = modalOverlay.querySelector('.btn-action-approve');
    const rejectBtn = modalOverlay.querySelector('.btn-action-reject');

    // Variável para armazenar o timeout da simulação (para poder cancelá-lo, se necessário)
    let qrSimulationTimeout;

    // --- Funções do Modal ---
    function openCatracaModal() {
        // Reinicia o estado visual
        catracaText.textContent = "Escaneando QR Code...";
        progressBar.style.width = '0%'; // Inicia a barra zerada
        progressBar.style.backgroundColor = '#007bff'; // Azul padrão (leitura)
        progressBar.style.transition = 'none'; // Remove transição para o reset ser instantâneo

        // Garante que o modal esteja visível
        modalOverlay.style.display = 'flex';
        
        // Inicia a simulação
        startQrSimulation();
    }

    function closeCatracaModal() {
        // Limpa o timeout para interromper a simulação se o modal for fechado antes de terminar
        clearTimeout(qrSimulationTimeout);
        modalOverlay.style.display = 'none';
    }

    // --- Simulação do QR Code ---
    function startQrSimulation() {
        const totalDuration = 3000; // 3 segundos para simular a leitura do QR Code

        // 1. Inicia a animação da barra (do 0% para 100% em 3s)
        // Usamos um pequeno timeout para garantir que o 'transition: none' no openCatracaModal seja processado.
        setTimeout(() => {
             progressBar.style.transition = `width ${totalDuration / 1000}s linear`;
             progressBar.style.width = '100%';
        }, 50);

        // 2. Após 3 segundos (totalDuration), muda o estado
        qrSimulationTimeout = setTimeout(() => {
            // Remove a transição para que as próximas mudanças sejam instantâneas
            progressBar.style.transition = 'none'; 
            
            // Muda a cor da barra para verde, indicando sucesso na leitura
            progressBar.style.backgroundColor = '#1abc9c'; 
            
            // Corrige o texto para "Aguardando Confirmação..."
            catracaText.textContent = "Aguardando Confirmação...";
        }, totalDuration);
    }


    // --- Event Listeners ---
    
    // Abrir modal
    openModalBtn.addEventListener('click', openCatracaModal);

    // Fechar modal no 'X'
    closeModalBtn.addEventListener('click', closeCatracaModal);

    // Fechar modal ao clicar fora
    modalOverlay.addEventListener('click', function(e) {
        if (e.target === modalOverlay) {
            closeCatracaModal();
        }
    });

    // Ações de Confirmação
    approveBtn.addEventListener('click', () => {
        // Você faria uma chamada AJAX aqui
        alert('Acesso APROVADO! Simulação concluída.');
        closeCatracaModal();
    });

    rejectBtn.addEventListener('click', () => {
        // Você faria uma chamada AJAX aqui
        alert('Acesso RECUSADO! Simulação concluída.');
        closeCatracaModal();
    });