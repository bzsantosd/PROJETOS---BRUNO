<?php
// View/admin/lista_produtos.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - TechFit</title>
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

        .filters {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .filters select,
        .filters input {
            padding: 12px 15px;
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

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(0, 200, 81, 0.3);
            color: #00ff88;
        }

        .badge-warning {
            background: rgba(255, 193, 7, 0.3);
            color: #ffd54f;
        }

        .badge-danger {
            background: rgba(255, 68, 68, 0.3);
            color: #ff6b6b;
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

        .btn-edit {
            background: rgba(0, 123, 255, 0.3);
            color: #5dade2;
        }

        .btn-edit:hover {
            background: rgba(0, 123, 255, 0.5);
        }

        .btn-delete {
            background: rgba(255, 68, 68, 0.3);
            color: #ff6b6b;
        }

        .btn-delete:hover {
            background: rgba(255, 68, 68, 0.5);
        }

        .btn-add {
            background: linear-gradient(135deg, #a020f0, #8a2be2);
            color: white;
            padding: 12px 25px;
            font-weight: 600;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.4);
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
                <h1><i class="fas fa-box"></i> Gerenciar Produtos</h1>
            </div>
            <a href="/admin/produtos/cadastrar" class="btn btn-add">
                <i class="fas fa-plus"></i> Cadastrar Produto
            </a>
        </div>

        <?php
        if (isset($_SESSION['sucesso_produto'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['sucesso_produto']) . '</div>';
            unset($_SESSION['sucesso_produto']);
        }

        if (isset($_SESSION['erro_produto'])) {
            echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['erro_produto']) . '</div>';
            unset($_SESSION['erro_produto']);
        }
        ?>

        <div class="filters">
            <label>Filtrar por categoria:</label>
            <select id="filtroCategoria" onchange="filtrarPorCategoria()">
                <option value="">Todas</option>
                <option value="Suplemento">Suplemento</option>
                <option value="Vestuário">Vestuário</option>
                <option value="Acessório">Acessório</option>
                <option value="Equipamento">Equipamento</option>
            </select>

            <input type="text" id="busca" placeholder="Buscar produto..." onkeyup="buscarProduto()">
        </div>

        <div class="table-container">
            <?php if (empty($produtos)): ?>
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h2>Nenhum produto cadastrado</h2>
                    <p>Clique em "Cadastrar Produto" para adicionar o primeiro produto.</p>
                </div>
            <?php else: ?>
                <table id="tabelaProdutos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                        <tr data-categoria="<?= htmlspecialchars($produto['categoria']) ?>">
                            <td>#<?= $produto['Id_Produtos'] ?></td>
                            <td><strong><?= htmlspecialchars($produto['nome_produto']) ?></strong></td>
                            <td><?= htmlspecialchars($produto['categoria']) ?></td>
                            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td>
                                <?php if ($produto['quantidade'] <= 5): ?>
                                    <span class="badge badge-danger">
                                        <?= $produto['quantidade'] ?> un.
                                    </span>
                                <?php elseif ($produto['quantidade'] <= 20): ?>
                                    <span class="badge badge-warning">
                                        <?= $produto['quantidade'] ?> un.
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-success">
                                        <?= $produto['quantidade'] ?> un.
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($produto['quantidade'] > 0): ?>
                                    <span class="badge badge-success">Disponível</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Esgotado</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="/admin/produtos/editar/<?= $produto['Id_Produtos'] ?>" 
                                       class="btn btn-edit">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <button onclick="confirmarExclusao(<?= $produto['Id_Produtos'] ?>)" 
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
        function filtrarPorCategoria() {
            const categoria = document.getElementById('filtroCategoria').value;
            const linhas = document.querySelectorAll('#tabelaProdutos tbody tr');

            linhas.forEach(linha => {
                if (categoria === '' || linha.dataset.categoria === categoria) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        }

        function buscarProduto() {
            const termo = document.getElementById('busca').value.toLowerCase();
            const linhas = document.querySelectorAll('#tabelaProdutos tbody tr');

            linhas.forEach(linha => {
                const texto = linha.textContent.toLowerCase();
                linha.style.display = texto.includes(termo) ? '' : 'none';
            });
        }

        function confirmarExclusao(id) {
            if (confirm('Tem certeza que deseja excluir este produto?')) {
                window.location.href = '/admin/produtos/remover/' + id;
            }
        }
    </script>
</body>
</html>