document.addEventListener('DOMContentLoaded', () => {
    
    // ==========================================================
    // --- LÓGICA DE CARREGAMENTO DE DADOS DO CLIENTE (NOVO) ---
    // ==========================================================
    const userDataJSON = localStorage.getItem('currentUserData');
    const userData = userDataJSON ? JSON.parse(userDataJSON) : null;
    
    // Elementos a serem preenchidos
    const headerUserName = document.getElementById('header-user-name');
    const cardHolderName = document.getElementById('card-holder-name');
    const welcomeMessage = document.getElementById('welcome-message');

    if (userData) {
        // Pega o nome completo do usuário ou 'Cliente'
        const nomeCompleto = userData.nome || 'Cliente'; 
        const primeiroNome = userData.nome ? userData.nome.split(' ')[0] : 'Cliente';
        
        // 1. Injeta o nome no cabeçalho
        if (headerUserName) {
            headerUserName.textContent = nomeCompleto;
        }

        // 2. Injeta o nome no cartão de pagamento
        if (cardHolderName) {
            cardHolderName.textContent = nomeCompleto;
        }
        
        // 3. Atualiza a mensagem de boas-vindas
        if (welcomeMessage) {
            welcomeMessage.textContent = `Bem-vindo(a) de volta, ${primeiroNome}!`;
        }

        // NOTA SOBRE A FOTO: A imagem está hardcoded no HTML,
        // mas você poderia alterá-la aqui se a URL da foto estivesse no localStorage:
        /*
        const userAvatar = document.getElementById('user-avatar');
        if (userAvatar && userData.foto_url) {
            userAvatar.style.backgroundImage = `url('${userData.foto_url}')`;
        }
        */
        
    } else {
        // Se não houver dados, define padrões
        if (headerUserName) headerUserName.textContent = 'Visitante';
        if (cardHolderName) cardHolderName.textContent = 'Titular do Cartão';
        if (welcomeMessage) welcomeMessage.textContent = 'Bem-vindo(a) de volta!';
    }


    // ==========================================================
    // --- LÓGICA ORIGINAL DE AGENDAMENTO (MANTIDA) ---
    // ==========================================================
    const dayButtons = document.querySelectorAll('.day-button');
    const scheduleDateElement = document.querySelector('.schedule-date .date');
    const dayOfWeekElement = document.querySelector('.schedule-date .day-of-week');
    const allSchedules = document.querySelectorAll('.class-list');

    // Mapeamentos
    const dayNameMap = {
        'dom': 'Dom', 'seg': 'Seg', 'ter': 'Ter', 'qua': 'Qua',
        'qui': 'Qui', 'sex': 'Sex', 'sab': 'Sáb'
    };
    const dateMap = {
        // Mantenha o mapeamento de datas que você usou, é uma simulação
        'dom': '13', 'seg': '14', 'ter': '15', 'qua': '16', 
        'qui': '17', 'sex': '18', 'sab': '19' 
    };

    dayButtons.forEach(button => {
        button.addEventListener('click', () => {
            const selectedDay = button.getAttribute('data-day');

            // 1. Alternar a classe 'active' nos botões
            dayButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // 2. Atualizar a data e o dia da semana no cabeçalho do Schedule
            if (scheduleDateElement) scheduleDateElement.textContent = dateMap[selectedDay] || '';
            if (dayOfWeekElement) dayOfWeekElement.textContent = dayNameMap[selectedDay] || '';

            // 3. Mostrar/Esconder os horários de aula
            allSchedules.forEach(schedule => {
                schedule.classList.add('hidden');
            });

            const targetSchedule = document.getElementById(`${selectedDay}-schedule`);
            if (targetSchedule) {
                targetSchedule.classList.remove('hidden');
            }
        });
    });

    // Simular o clique inicial no primeiro botão (ex: 'seg') para carregar a agenda inicial
    const initialDayButton = document.querySelector('.day-button[data-day="seg"]'); 
    if (initialDayButton) {
        initialDayButton.click();
    }
});