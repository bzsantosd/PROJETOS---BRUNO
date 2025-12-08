<?php include '../Layout/header.php'; ?>

<div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
    <div class="container-fluid py-3">
        <h1 class="display-5 fw-bold text-primary">Bem-vindo, Atleta!</h1>
        <p class="col-md-8 fs-4 text-muted">Acompanhe seu progresso, visualize sua ficha de treino e reserve horários nas aulas coletivas.</p>
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
            <a href="../treino/lista.php" class="btn btn-primary btn-lg px-4 me-md-2">
                <i class="bi bi-card-list"></i> Ver Treinos
            </a>
            <a href="../aula/reservar.php" class="btn btn-outline-secondary btn-lg px-4">
                <i class="bi bi-calendar-check"></i> Agendar Aula
            </a>
        </div>
    </div>
</div>

<div class="row align-items-md-stretch">
    <div class="col-md-6 mb-3">
        <div class="h-100 p-5 text-bg-dark rounded-3">
            <h2>Próximo Treino</h2>
            <p>Seu próximo treino sugerido é: <strong>Peito e Tríceps (A)</strong>.</p>
            <button class="btn btn-outline-light" type="button">Iniciar Agora</button>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="h-100 p-5 bg-white border rounded-3 shadow-sm">
            <h2>Avisos</h2>
            <p>A academia funcionará em horário reduzido neste feriado. Confira a grade de horários.</p>
            <button class="btn btn-outline-primary" type="button">Ler mais</button>
        </div>
    </div>
</div>

<?php include '../Layout/footer.php'; ?>