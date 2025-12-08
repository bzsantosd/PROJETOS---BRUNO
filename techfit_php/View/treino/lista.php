<?php include '../Layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-dumbbell"></i> Minhas Fichas de Treino</h2>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle bg-white shadow-sm rounded">
        <thead class="table-dark">
            <tr>
                <th>Nome / Sigla</th>
                <th>Objetivo</th>
                <th>Grupo Muscular</th>
                <th>Status</th>
                <th class="text-end">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="fw-bold">Treino A</td>
                <td>Hipertrofia</td>
                <td>Peito e Tríceps</td>
                <td><span class="badge bg-success">Ativo</span></td>
                <td class="text-end">
                    <a href="detalhes.php?id=1" class="btn btn-sm btn-outline-primary">Ver Exercícios</a>
                </td>
            </tr>
            <tr>
                <td class="fw-bold">Treino B</td>
                <td>Hipertrofia</td>
                <td>Costas e Bíceps</td>
                <td><span class="badge bg-success">Ativo</span></td>
                <td class="text-end">
                    <a href="detalhes.php?id=2" class="btn btn-sm btn-outline-primary">Ver Exercícios</a>
                </td>
            </tr>
            <tr>
                <td class="fw-bold">Treino C</td>
                <td>Resistência</td>
                <td>Pernas e Ombros</td>
                <td><span class="badge bg-secondary">Inativo</span></td>
                <td class="text-end">
                    <a href="detalhes.php?id=3" class="btn btn-sm btn-outline-primary">Ver Exercícios</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php include '../Layout/footer.php'; ?>