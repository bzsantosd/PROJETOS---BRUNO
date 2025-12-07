document.addEventListener('DOMContentLoaded', () => {
    const dayButtons = document.querySelectorAll('.day-button');
    const scheduleDateElement = document.querySelector('.schedule-date .date');
    const dayOfWeekElement = document.querySelector('.schedule-date .day-of-week');
    const allSchedules = document.querySelectorAll('.class-list');

    // Mapeamento para o dia da semana no Schedule Date
    const dayNameMap = {
        'dom': 'Dom',
        'seg': 'Seg',
        'ter': 'Ter',
        'qua': 'Qua',
        'qui': 'Qui',
        'sex': 'Sex',
        'sab': 'Sáb'
    };

    // Mapeamento para o número da data (simulação)
    const dateMap = {
        'dom': '13', // Dia 13 no mockup
        'seg': '14',
        'ter': '15',
        'qua': '16',
        'qui': '17',
        'sex': '18',
        'sab': '19'
    };

    dayButtons.forEach(button => {
        button.addEventListener('click', () => {
            const selectedDay = button.getAttribute('data-day');

            // 1. Alternar a classe 'active' nos botões
            dayButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // 2. Atualizar a data e o dia da semana
            dayOfWeekElement.textContent = dayNameMap[selectedDay];
            scheduleDateElement.textContent = dateMap[selectedDay];

            // 3. Mostrar/Esconder a lista de classes (Agenda)
            allSchedules.forEach(schedule => {
                schedule.classList.add('hidden');
            });
            
            // Tenta encontrar a agenda correspondente e a exibe
            const targetSchedule = document.getElementById(`${selectedDay}-schedule`);
            if (targetSchedule) {
                targetSchedule.classList.remove('hidden');
            }
        });
    });

    // Código para simular o clique inicial (opcional, já está no HTML)
    // document.querySelector('.day-button.active').click(); 
});
// perfil.js (para carregar na tela inicial.html ou perfil.html)

document.addEventListener('DOMContentLoaded', () => {
    // Pega os dados do usuário salvos no localStorage
    const userDataJSON = localStorage.getItem('currentUserData');
    const userData = userDataJSON ? JSON.parse(userDataJSON) : null;
    
    // Supondo que você tenha um elemento na tela inicial para mostrar as boas-vindas:
    const welcomeMessage = document.getElementById('welcome-message');
    
    if (userData && welcomeMessage) {
        // Exibe o nome do usuário cadastrado na tela inicial
        welcomeMessage.textContent = `Bem-vindo(a) de volta, ${userData.nome.split(' ')[0]}!`;
        
        // Simulação de "Dados da Conta" na tela inicial (você precisaria criar esses elementos no HTML)
        /*
        document.getElementById('profile-name').textContent = userData.nome;
        document.getElementById('profile-email').textContent = userData.email;
        document.getElementById('profile-cpf').textContent = userData.cpf;
        */
        
    } else if (welcomeMessage) {
        // Se não houver dados salvos, exibe a mensagem padrão
        welcomeMessage.textContent = 'Bem-vindo(a) à TechFit.';
    }
});