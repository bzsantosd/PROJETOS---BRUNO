document.addEventListener('DOMContentLoaded', () => {
    const statusButtons = document.querySelectorAll('.status-btn');
    const statusInput = document.getElementById('status');
    const productForm = document.getElementById('product-form');
    const actionButtons = document.querySelectorAll('.action-btn');

    // --- 1. Lógica dos Botões de Status (ATIVO/INATIVO) ---
    statusButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove 'selected' de todos os botões
            statusButtons.forEach(btn => btn.classList.remove('selected'));
            
            // Adiciona 'selected' ao botão clicado
            button.classList.add('selected');
            
            // Atualiza o valor do campo oculto (que seria enviado ao servidor)
            statusInput.value = button.getAttribute('data-status');
            
            console.log(`Status alterado para: ${statusInput.value}`);
        });
    });

    // --- 2. Simulação de Ações do Formulário ---

    // Ação principal (Cadastrar)
    productForm.addEventListener('submit', (e) => {
        e.preventDefault(); // Previne o envio padrão do formulário
        
        // Coleta os dados do formulário (Exemplo)
        const formData = new FormData(productForm);
        const data = Object.fromEntries(formData.entries());
        
        console.log('Ação: CADASTRAR');
        console.log('Dados do Produto:', data);
        
        alert('Produto Cadastrado com Sucesso! (Simulação)');
        // Aqui você faria uma chamada API para enviar os dados
    });

    // Ações secundárias (Atualizar e Deletar)
    actionButtons.forEach(button => {
        if (!button.classList.contains('register-btn')) {
            button.addEventListener('click', () => {
                const action = button.textContent.toUpperCase();
                
                // Em um sistema real, essas ações precisariam do Código (ID) do produto
                const productCode = document.getElementById('codigo').value;
                
                if (!productCode && (action === 'ATUALIZAR' || action === 'DELETAR')) {
                    alert(`Por favor, preencha o campo "Código" para ${action}.`);
                    return;
                }

                console.log(`Ação: ${action}`);
                console.log(`Código do Produto: ${productCode}`);
                
                alert(`Ação de ${action} acionada para o código ${productCode || '(não preenchido)'}. (Simulação)`);
                // Aqui você faria chamadas API específicas (PUT para atualizar, DELETE para deletar)
            });
        }
    });

});