
// // 2. FUNCIONALIDADE DA BARRA DE NAVEGAÇÃO
// const navItems = document.querySelectorAll('.nav-item');

// navItems.forEach(item => {
//     item.addEventListener('click', function(event) {
//         event.preventDefault();

//         // 2a. Remove a classe 'active' de todos os itens
//         navItems.forEach(i => i.classList.remove('active'));

//         // 2b. Adiciona a classe 'active' ao item clicado para destaque visual
//         item.classList.add('active');

//         // 2c. Simula a navegação com um alerta
//         const pageName = item.querySelector('a').getAttribute('data-page');
        
//         switch (pageName) {
//             case 'home':
//                 alert('Você está na página HOME.');
//                 break;
//             case 'planos':
//                 alert('Carregando conteúdo da página PLANOS...');
//                 break;
//             case 'modalidades':
//                 alert('Carregando conteúdo das MODALIDADES...');
//                 break;
//             case 'sobre':
//                 alert('Carregando nossa história e SOBRE NÓS...');
//                 break;
//             default:
//                 alert('Página não encontrada.');
//         }
//     });
    document.addEventListener('DOMContentLoaded', function() {
    // 1. Pega o elemento do botão usando o seu ID
    const btnExperimental = document.getElementById('btnAulaExperimental');

    // 2. Adiciona um "ouvinte" de evento de clique
    if (btnExperimental) {
        btnExperimental.addEventListener('click', function() {
            // 3. Redireciona o usuário para a página de login

            window.location.href = 'index.html'; 
        });
    }
});

});