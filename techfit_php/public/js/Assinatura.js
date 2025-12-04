document.addEventListener('DOMContentLoaded', function() {
    // Recupera os dados do plano selecionado
    const dadosPlanoJSON = sessionStorage.getItem('planoSelecionado');
    
    if (dadosPlanoJSON) {
        const dadosPlano = JSON.parse(dadosPlanoJSON);
        
        // Atualiza o nome do plano
        const nomePlanoElement = document.querySelector('.plan-info h3');
        if (nomePlanoElement) {
            nomePlanoElement.textContent = dadosPlano.nome;
        }
        
        // Atualiza o total devido (preço novo mensal)
        const totalElement = document.querySelector('.total-value');
        if (totalElement) {
            totalElement.textContent = `R$ ${dadosPlano.precoNovo}`;
        }
        
        // Calcula o valor anual (preço mensal * 12)
        const valorAnual = valorNovo * 12;
        
        // Atualiza a informação de renovação
        const renovacaoElement = document.querySelector('.renewal-info');
        if (renovacaoElement) {
            renovacaoElement.textContent = `Renovação anual por R$ ${valorAnual.toFixed(2).replace('.', ',')}`;
        }
        
        // Adiciona tag de recomendação apenas para o plano Premium
        const recommendedTag = document.querySelector('.recommended-tag');
        if (recommendedTag) {
            if (dadosPlano.nome.includes('PREMIUM')) {
                recommendedTag.style.display = 'inline-block';
            } else {
                recommendedTag.style.display = 'none';
            }
        }
    } else {
        // Se não houver plano selecionado, redireciona para a página de planos
        console.log('Nenhum plano selecionado');
        // Descomente a linha abaixo se quiser redirecionar automaticamente
        // window.location.href = 'Planos.html';
    }
});