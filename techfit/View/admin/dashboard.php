<?php
// View/admin/dashboard.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se está logado
if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - TechFit</title>
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
        }

        /* HEADER */
        .header {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid rgba(138, 43, 226, 0.3);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8a2be2, #a020f0);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .user-details span {
            display: block;
        }

        .user-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-role {
            color: #8a2be2;
            font-size: 0.85rem;
        }

        .logo h1 {
            font-size: 2rem;
            background: linear-gradient(135deg, #8a2be2, #a020f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* MENU NAVEGAÇÃO */
        .nav-menu {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px 40px;
            display: flex;
            gap: 30px;
            border-bottom: 1px solid rgba(138, 43, 226, 0.2);
        }

        .nav-menu a {
            color: #aaa;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: white;
            background: rgba(138, 43, 226, 0.3);
        }

        /* CONTAINER PRINCIPAL */
        .container {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 40px;
        }

        /* CARDS DE ESTATÍSTICAS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(138, 43, 226, 0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(138, 43, 226, 0.3);
        }

        .stat-card h3 {
            font-size: 0.9rem;
            color: #aaa;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #8a2be2;
            margin-bottom: 10px;
        }

        .stat-icon {
            font-size: 3rem;
            color: rgba(138, 43, 226, 0.5);
            float: right;
        }

        .stat-change {
            font-size: 0.85rem;
            color: #00ff88;
        }

        .stat-change.negative {
            color: #ff4444;
        }

        /* SEÇÕES DE CONTEÚDO */
        .content-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(138, 43, 226, 0.3);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 {
            font-size: 1.5rem;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #a020f0, #8a2be2);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(138, 43, 226, 0.4);
        }

        /* TABELAS */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: rgba(138, 43, 226, 0.2);
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid rgba(138, 43, 226, 0.5);
        }

        td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background: rgba(138, 43, 226, 0.1);
        }

        /* ALERTAS */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-warning {
            background: rgba(255, 193, 7, 0.2);
            border-left: 4px solid #ffc107;
            color: #ffd54f;
        }

        /* RESPONSIVO */
        @media (max-width: 768px) {
            .header, .nav-menu, .container {
                padding: 20px;
            }

            .nav-menu {
                flex-direction: column;
                gap: 10px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="user-info">
            <div class="user-avatar">
                <?= strtoupper(substr($_SESSION['user_nome'], 0, 1)) ?>
            </div>
            <div class="user-details">
                <span class="user-name"><?= htmlspecialchars($_SESSION['user_nome']) ?></span>
                <span class="user-role">ADMINISTRADOR</span>
            </div>
        </div>

        <div class="logo">
            <h1>TECHFIT</h1>
        </div>

        <a href="/logout" class="btn btn-primary">
            <i class="fas fa-sign-out-alt"></i> Sair
        </a>
    </header>

    <!-- MENU NAVEGAÇÃO -->
    <nav class="nav-menu">
        <a href="/admin/dashboard" class="active">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="/admin/alunos">
            <i class="fas fa-users"></i> Alunos
        </a>
        <a href="/admin/produtos">
            <i class="fas fa-box"></i> Produtos
        </a>
        <a href="/admin/produtos/cadastrar">
            <i class="fas fa-plus-circle"></i> Cadastrar Produto
        </a>
    </nav>

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="container">
        
        <!-- CARDS DE ESTATÍSTICAS -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-users stat-icon"></i>
                <h3>Total de Alunos</h3>
                <div class="stat-value"><?= $totalAlunos ?? 0 ?></div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i> +12% este mês
                </div>
            </div>

            <div class="stat-card">
                <i class="fas fa-box stat-icon"></i>
                <h3>Produtos Cadastrados</h3>
                <div class="stat-value"><?= $totalProdutos ?? 0 ?></div>
                <div class="stat-change">
                    <i class="fas fa-arrow-up"></i> +5% este mês
                </div>
            </div>

            <div class="stat-card">
                <i class="fas fa-dollar-sign stat-icon"></i>
                <h3>Valor em Estoque</h3>
                <div class="stat-value">R$ <?= number_format($valorEstoque ?? 0, 2, ',', '.') ?></div>
                <div class="stat-change">
                    <i class="fas fa-chart-line"></i> Atualizado
                </div>
            </div>

            <div class="stat-card">
                <i class="fas fa-exclamation-triangle stat-icon"></i>
                <h3>Produtos Baixo Estoque</h3>
                <div class="stat-value"><?= count($produtosBaixoEstoque ?? []) ?></div>
                <div class="stat-change negative">
                    <i class="fas fa-arrow-down"></i> Atenção necessária
                </div>
            </div>
        </div>

        <!-- ALERTA DE PRODUTOS COM BAIXO ESTOQUE -->
        <?php if (!empty($produtosBaixoEstoque)): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Atenção!</strong> Existem <?= count($produtosBaixoEstoque) ?> produto(s) com estoque baixo.
                <a href="/admin/produtos" style="color: #fff; text-decoration: underline; margin-left: 10px;">Ver produtos</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- PRODUTOS COM BAIXO ESTOQUE -->
        <?php if (!empty($produtosBaixoEstoque)): ?>
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-boxes"></i> Produtos com Baixo Estoque</h2>
                <a href="/admin/produtos" class="btn btn-primary">Ver Todos</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Preço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($produtosBaixoEstoque, 0, 5) as $produto): ?>
                    <tr>
                        <td><?= htmlspecialchars($produto['nome_produto']) ?></td>
                        <td><?= htmlspecialchars($produto['categoria']) ?></td>
                        <td style="color: #ff4444; font-weight: bold;">
                            <?= $produto['quantidade'] ?> unidades
                        </td>
                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- RELATÓRIO POR CATEGORIA -->
        <?php if (!empty($relatorioCategoria)): ?>
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-chart-pie"></i> Relatório por Categoria</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Total de Produtos</th>
                        <th>Total em Estoque</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($relatorioCategoria as $cat): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($cat['categoria']) ?></strong></td>
                        <td><?= $cat['total_produtos'] ?></td>
                        <td><?= $cat['total_estoque'] ?> unidades</td>
                        <td style="color: #00ff88; font-weight: bold;">
                            R$ <?= number_format($cat['valor_total'], 2, ',', '.') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- ÚLTIMOS ALUNOS CADASTRADOS -->
        <?php if (!empty($alunos)): ?>
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-user-plus"></i> Últimos Alunos Cadastrados</h2>
                <a href="/admin/alunos" class="btn btn-primary">Ver Todos</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>CPF</th>
                        <th>Contato</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($alunos, -5) as $aluno): ?>
                    <tr>
                        <td><?= htmlspecialchars($aluno['nome_aluno']) ?></td>
                        <td><?= htmlspecialchars($aluno['email']) ?></td>
                        <td><?= htmlspecialchars($aluno['cpf']) ?></td>
                        <td><?= htmlspecialchars($aluno['contato'] ?? '-') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>