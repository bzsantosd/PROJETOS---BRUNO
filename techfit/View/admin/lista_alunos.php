<?php
// View/admin/lista_alunos.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Alunos - TechFit</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #ffffff;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2rem;
            color: #8a2be2;
        }

        .back-link {
            color: #8a2be2;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            border: 2px solid #8a2be2;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            background: #8a2be2;
            color: white;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: rgba(0, 200, 81, 0.2);
            border-left: 4px solid #00C851;
            color: #00ff88;
        }

        .alert-error {
            background: rgba(255, 68, 68, 0.2);
            border-left: 4px solid #ff4444;
            color: #ff6b6b;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 10px;
            border: 1px solid rgba(138, 43, 226, 0.3);
        }

        .stat-box h3 {
            font-size: 0.9rem;
            color: #aaa;
            margin-bottom: 10px;
        }

        .stat-box .value {
            font-size: 2rem;
            color: #8a2be2;
            font-weight: bold;
        }

        .search-bar {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .search-bar input {
            width: 100%;
            padding: 15px;
            border: 2px solid rgba(138, 43, 226, 0.3);
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-radius: 8px;
            font-size: 1rem;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: rgba(138, 43, 226, 0.3);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #8a2be2;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background: rgba(138, 43, 226, 0.1);
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background: rgba(0, 200, 81, 0.3);
            color: #00ff88;
        }

        .btn-view:hover {
            background: rgba(0, 200, 81, 0.5);
        }

        .btn-delete {
            background: rgba(255, 68, 68, 0.3);
            color: #ff6b6b;
        }

        .btn-delete:hover {
            background: rgba(255, 68, 68, 0.5);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #aaa;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: rgba(138, 43, 226, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <a href="/admin/dashboard" class="back-link">
                    <i class="fas fa-arrow-left"></i> Voltar ao Dashboard
                </a>
                <h1><i class="fas fa-users"></i> Gerenciar Alunos</h1>
            </div>
        </div>

        <?php
        if (isset($_SESSION['sucesso_aluno'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['sucesso_aluno']) . '</div>';
            unset($_SESSION['sucesso_aluno']);
        }

        if (isset($_SESSION['erro_aluno'])) {
            echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['erro_aluno']) . '</div>';
            unset($_SESSION['erro_aluno']);
        }
        ?>

        <div class="stats-bar">
            <div class="stat-box">
                <h3>Total de Alunos</h3>
                <div class="value"><?= count($alunos) ?></div>
            </div>
            <div class="stat-box">
                <h3>Novos Este Mês</h3>
                <div class="value">
                    <?php
                    $novosEsteMes = array_filter($alunos, function($a) {
                        // Simula contagem (você pode usar data_cadastro se tiver)
                        return true;
                    });
                    echo min(15, count($novosEsteMes));
                    ?>
                </div>
            </div>
            <div class="stat-box">
                <h3>Ativos</h3>
                <div class="value"><?= count($alunos) ?></div>
            </div>
        </div>

        <div class="search-bar">
            <input type="text" id="busca" placeholder="🔍 Buscar aluno por nome, email ou CPF..." 
                   onkeyup="buscarAluno()">
        </div>

        <div class="table-container">
            <?php if (empty($alunos)): ?>
                <div class="empty-state">
                    <i class="fas fa-user-slash"></i>
                    <h2>Nenhum aluno cadastrado</h2>
                    <p>Os alunos que se cadastrarem aparecerão aqui.</p>
                </div>
            <?php else: ?>
                <table id="tabelaAlunos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>CPF</th>
                            <th>Contato</th>
                            <th>Endereço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td>#<?= $aluno['Id_Aluno'] ?></td>
                            <td><strong><?= htmlspecialchars($aluno['nome_aluno']) ?></strong></td>
                            <td><?= htmlspecialchars($aluno['email']) ?></td>
                            <td><?= htmlspecialchars($aluno['cpf']) ?></td>
                            <td><?= htmlspecialchars($aluno['contato'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($aluno['endereco'] ?? '-') ?></td>
                            <td>
                                <div class="action-btns">
                                    <a href="/admin/alunos/ver/<?= $aluno['Id_Aluno'] ?>" 
                                       class="btn btn-view">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <button onclick="confirmarExclusao(<?= $aluno['Id_Aluno'] ?>, '<?= htmlspecialchars($aluno['nome_aluno']) ?>')" 
                                            class="btn btn-delete">
                                        <i class="fas fa-trash"></i> Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function buscarAluno() {
            const termo = document.getElementById('busca').value.toLowerCase();
            const linhas = document.querySelectorAll('#tabelaAlunos tbody tr');

            linhas.forEach(linha => {
                const texto = linha.textContent.toLowerCase();
                linha.style.display = texto.includes(termo) ? '' : 'none';
            });
        }

        function confirmarExclusao(id, nome) {
            if (confirm(`Tem certeza que deseja excluir o aluno "${nome}"?\n\nEsta ação não pode ser desfeita!`)) {
                window.location.href = '/admin/alunos/remover/' + id;
            }
        }
    </script>
</body>
</html>