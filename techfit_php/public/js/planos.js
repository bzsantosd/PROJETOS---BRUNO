document.addEventListener('DOMContentLoaded', function() {
    // Seleciona todos os botões de "Assinar Agora"
    const botoesAssinar = document.querySelectorAll('.product-price-box a');
    
    // Itera sobre cada botão para adicionar o evento de clique
    botoesAssinar.forEach(function(botao) {
        botao.addEventListener('click', function(e) {
            e.preventDefault(); // Impede o comportamento padrão do link

            // Pega o elemento card pai do botão clicado
            const card = this.closest('.product-card');
            
            // Extrai as informações do plano
            const nomePlano = card.querySelector('.product-title').textContent.trim();
            const precoAntigoElement = card.querySelector('.price-old');
            const precoNovoElement = card.querySelector('.price-new');
            
            // Extrai o texto do preço, com fallback para 'N/A'
            const precoAntigo = precoAntigoElement ? precoAntigoElement.textContent.trim() : 'N/A';
            const precoNovo = precoNovoElement ? precoNovoElement.textContent.trim() : 'N/A';
            
            // Extrai apenas os números e vírgulas (para separar R$ do valor)
            const valorAntigo = precoAntigo.match(/[\d,]+/)?.[0] || 'N/A';
            const valorNovo = precoNovo.match(/[\d,]+/)?.[0] || 'N/A';
            
            // Cria um objeto com os dados do plano
            const dadosPlano = {
                nome: nomePlano,
                precoAntigo: valorAntigo,
                precoNovo: valorNovo
            };
            
            // Salva os dados do plano no sessionStorage
            sessionStorage.setItem('planoSelecionado', JSON.stringify(dadosPlano));
            
            // Redireciona o usuário para a página de assinatura
            window.location.href = 'Assinatura.html';
        });
    });
});