<?php include '../Layout/header.php'; ?>

<h2 class="mb-4">Agenda de Aulas Coletivas</h2>

<div class="alert alert-info" role="alert">
  <i class="bi bi-info-circle"></i> Selecione uma aula abaixo para garantir sua vaga. As vagas são limitadas!
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark fw-bold">Hoje - 18:00</div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Zumba Dance</h5>
                <p class="card-text text-muted">Queime calorias se divertindo com ritmos latinos.</p>
                <ul class="list-unstyled mb-4">
                    <li><strong>Prof:</strong> Ana Souza</li>
                    <li><strong>Duração:</strong> 45 min</li>
                    <li><strong>Vagas:</strong> <span class="text-danger">Restam 3</span></li>
                </ul>
                <button class="btn btn-dark mt-auto w-100">Reservar Vaga</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark fw-bold">Hoje - 19:00</div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Spinning (Bike)</h5>
                <p class="card-text text-muted">Treino cardiovascular intenso simulando ciclismo.</p>
                <ul class="list-unstyled mb-4">
                    <li><strong>Prof:</strong> Carlos Silva</li>
                    <li><strong>Duração:</strong> 50 min</li>
                    <li><strong>Vagas:</strong> <span class="text-success">Disponível</span></li>
                </ul>
                <button class="btn btn-dark mt-auto w-100">Reservar Vaga</button>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 opacity-75">
            <div class="card-header bg-secondary text-white">Amanhã - 07:00</div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">Yoga Morning</h5>
                <p class="card-text text-muted">Flexibilidade e respiração para começar o dia.</p>
                <ul class="list-unstyled mb-4">
                    <li><strong>Prof:</strong> Julia M.</li>
                    <li><strong>Duração:</strong> 60 min</li>
                    <li><strong>Vagas:</strong> <span class="text-success">Disponível</span></li>
                </ul>
                <button class="btn btn-outline-dark mt-auto w-100">Agendar Futuramente</button>
            </div>
        </div>
    </div>
</div>

<?php include '../Layout/footer.php'; ?>