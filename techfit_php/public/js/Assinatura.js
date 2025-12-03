document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.form-panel form');
    const emailInput = form.querySelector('input[type="email"]');
    const paymentBtn = form.querySelector('.secure-payment-btn');

    const validateEmail = (email) => {
        // Regex simples para validar o formato do email
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Exemplo: Validação de E-mail
        if (!validateEmail(emailInput.value)) {
            alert('Por favor, insira um endereço de e-mail válido.');
            emailInput.focus();
            return;
        }

        // Adicionar mais validações aqui (cartão, CVV, etc.)

        // Simulação de clique de sucesso
        paymentBtn.textContent = 'PROCESSANDO...';
        paymentBtn.disabled = true;

        setTimeout(() => {
            alert('A compra foi simuladamente concluída!');
            paymentBtn.textContent = 'PAGAMENTO SEGURO';
            paymentBtn.disabled = false;
            // Redirecionar para uma página de confirmação
            // window.location.href = '/confirmation.html';
        }, 2000);
    });
});