document.addEventListener('DOMContentLoaded', () => {
    // Código JavaScript para interatividade (ex: clique em abas, animações, etc.)
    
    // Exemplo: Destacar o título ao carregar
    const mainTitle = document.querySelector('.main-title');
    if (mainTitle) {
        mainTitle.style.opacity = 0;
        setTimeout(() => {
            mainTitle.style.transition = 'opacity 1s ease-out';
            mainTitle.style.opacity = 1;
        }, 100);
    }
});