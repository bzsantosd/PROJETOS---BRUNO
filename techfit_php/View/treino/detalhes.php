<?php include '../Layout/header.php'; ?>

<div class="mb-3">
    <a href="lista.php" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Voltar para lista</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h3 class="card-title">Treino A - Peito e Tríceps</h3>
        <p class="card-text text-muted">Realizar este treino 2 vezes na semana. Descanso de 60s entre séries.</p>
    </div>
</div>

<h4 class="mb-3">Lista de Exercícios</h4>

<div class="list-group shadow-sm">
    <div class="list-group-item d-flex justify-content-between align-items-center p-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">1</div>
            <div>
                <h5 class="mb-0">Supino Reto com Barra</h5>
                <small class="text-muted">Cuidado com a postura da coluna.</small>
            </div>
        </div>
        <div class="text-end">
            <span class="badge bg-dark rounded-pill mb-1">4 Séries</span><br>
            <span class="badge bg-secondary rounded-pill">12 Repetições</span>
        </div>
    </div>

    <div class="list-group-item d-flex justify-content-between align-items-center p-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">2</div>
            <div>
                <h5 class="mb-0">Supino Inclinado (Halteres)</h5>
                <small class="text-muted">Banco a 45 graus.</small>
            </div>
        </div>
        <div class="text-end">
            <span class="badge bg-dark rounded-pill mb-1">3 Séries</span><br>
            <span class="badge bg-secondary rounded-pill">15 Repetições</span>
        </div>
    </div>

    <div class="list-group-item d-flex justify-content-between align-items-center p-3">
        <div class="d-flex align-items-center">
            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">3</div>
            <div>
                <h5 class="mb-0">Tríceps Corda (Polia)</h5>
                <small class="text-muted">Estenda o braço completamente.</small>
            </div>
        </div>
        <div class="text-end">
            <span class="badge bg-dark rounded-pill mb-1">4 Séries</span><br>
            <span class="badge bg-secondary rounded-pill">10 Repetições</span>
        </div>
    </div>
</div>

<div class="mt-4 text-center">
    <button class="btn btn-success btn-lg"><i class="bi bi-check-circle"></i> Concluir Treino</button>
</div>

<?php include '../Layout/footer.php'; ?>