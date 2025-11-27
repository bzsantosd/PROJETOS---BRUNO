<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM - TechFit Academia</title>
    <link rel="stylesheet" href="/techfit/public/css/style2.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        
        <header class="header">
            <div class="user-profile">
                <div class="profile-img"></div>
                <div class="user-info">
                    <span><?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? 'Administrador'); ?></span>
                    <span class="adm-label">| ADM</span>
                </div>
            </div>
            
            <div class="header-content">
                <h1 class="main-title">ACADEMIA TECHFIT</h1>
                <div class="logo-box" style="max-width: 150px;">
                    <img src="/techfit/public/images/Logotipo.png" alt="TechFit Logo" class="logo-img" style="width: 100%; height: auto; max-height: 125px;">
                </div>
            </div>
            
            <div class="logout-section">
                <a href="/techfit/logout" class="btn-logout">Sair</a>
            </div>
        </header>

        <nav class="period-nav" id="periodNav">
            <button class="nav-button" data-period="mes-anterior">Mês Anterior</button>
            <button class="nav-button active" data-period="este-mes">Este Mês</button>
            <button class="nav-button" data-period="este-ano">Este Ano</button>
        </nav>

        <main class="main-content">
            
            <!-- Estatísticas de Pessoas -->
            <div class="row row-people">
                <div class="card stat-card new-clients-card">
                    <h2 class="card-title">Novos Clientes</h2>
                    <div class="card-content">
                        <i class="fas fa-users icon-people"></i>
                        <span class="main-value"><?php echo $estatisticas['novos_clientes'] ?? 0; ?></span>
                        <div class="trend up">70%</div>
                    </div>
                </div>

                <div class="card stat-card total-clients-card">
                    <h2 class="card-title">Clientes</h2>
                    <div class="card-content">
                        <i class="fas fa-users icon-people"></i>
                        <span class="main-value"><?php echo $estatisticas['total_clientes'] ?? 0; ?></span>
                        <div class="trend up">10%</div>
                    </div>
                </div>

                <div class="card stat-card collaborators-card">
                    <h2 class="card-title">Colaboradores</h2>
                    <div class="card-content">
                        <i class="fas fa-users icon-people"></i>
                        <span class="main-value"><?php echo $estatisticas['colaboradores'] ?? 0; ?></span>
                        <span class="secondary-label">Total</span>
                    </div>
                </div>
            </div>
            
            <!-- Estatísticas de Produtos -->
            <div class="row row-products">
                
                <div class="card stat-card product-high-card">
                    <h2 class="card-title">Produto em Alta</h2>
                    <div class="product-stats">
                        <i class="fas fa-hand-holding-usd icon-money"></i>
                        
                        <div class="product-info-group">
                            <span class="product-name">
                                <?php echo htmlspecialchars($estatisticas['produto_mais_vendido']['nome'] ?? 'N/A'); ?>
                            </span>
                            <div class="product-values">
                                <div class="product-value-box">
                                    <span class="product-value-number green">
                                        <?php echo $estatisticas['produto_mais_vendido']['vendidos'] ?? 0; ?>
                                    </span>
                                    <span class="product-value-label">Vendidos</span>
                                </div>
                                
                                <div class="product-value-box">
                                    <span class="product-value-number">
                                        <?php echo $estatisticas['produto_mais_vendido']['estoque'] ?? 0; ?>
                                    </span>
                                    <span class="product-value-label">Em Estoque</span>
                                </div>

                                <div class="product-value-box">
                                    <span class="product-value-number green">
                                        <?php echo $estatisticas['produto_mais_vendido']['valor_obtido'] ?? 0; ?>
                                    </span>
                                    <span class="product-value-label">Valor Obtido</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card stat-card product-low-card">
                    <h2 class="card-title">Produtos estoque baixo</h2>
                    <div class="low-stock-content">
                        <div class="warning-section">
                             <i class="fas fa-chart-line icon-warning"></i>
                             <p>Necessário Reabastecer!</p>
                        </div>
                        
                        <?php if (!empty($produtosEstoqueBaixo)): ?>
                            <?php foreach (array_slice($produtosEstoqueBaixo, 0, 1) as $produto): ?>
                                <div class="stock-info">
                                    <p class="stock-name"><?php echo htmlspecialchars($produto['nome']); ?></p>
                                    <div class="stock-value-box">
                                        <span class="stock-value-number red"><?php echo $produto['estoque']; ?></span>
                                        <span class="stock-value-label">Em Estoque</span>
                                        <div class="trend down"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="text-align: center; color: #666;">Nenhum produto com estoque baixo</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Fluxo de Alunos -->
            <div class="row row-flow">
                <div class="card flow-card">
                    <h2 class="card-title">Fluxo de Alunos</h2>
                    <div class="flow-content">
                        <div class="flow-metric">
                            <span class="flow-value yellow">106</span>
                            <span class="flow-label">Média diária</span>
                        </div>
                        <div class="flow-chart">
                            <div class="chart-labels">
                                <span>D</span><span>S</span><span>T</span><span>Q</span><span>Q</span><span>S</span><span>S</span>
                            </div>
                            <div class="chart-line"></div>
                            <div class="chart-data-point red" style="height: 30px; left: 10%;"></div>
                            <div class="chart-data-point red" style="height: 80px; left: 25%;"></div>
                            <div class="chart-data-point red" style="height: 50px; left: 40%;"></div>
                            <div class="chart-data-point red" style="height: 90px; left: 55%;"></div>
                            <div class="chart-data-point red" style="height: 40px; left: 70%;"></div>
                            <div class="chart-data-point red" style="height: 70px; left: 85%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Menu de Ações Rápidas -->
            <div class="row row-actions">
                <div class="quick-actions">
                    <a href="/techfit/admin/usuarios" class="action-btn">
                        <i class="fas fa-users"></i>
                        <span>Gerenciar Usuários</span>
                    </a>
                    
                    <a href="/techfit/admin/produtos" class="action-btn">
                        <i class="fas fa-box"></i>
                        <span>Gerenciar Produtos</span>
                    </a>
                    
                    <a href="/techfit/admin/produtos/cadastrar" class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        <span>Cadastrar Produto</span>
                    </a>
                    
                    <a href="/techfit/admin/relatorio-vendas" class="action-btn">
                        <i class="fas fa-chart-bar"></i>
                        <span>Relatórios</span>
                    </a>
                </div>
            </div>
        </main>
    </div>
    
    <style>
        .logout-section {
            margin-left: auto;
        }
        
        .btn-logout {
            background-color: #5d0f99;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        
        .btn-logout:hover {
            background-color: #7a15c3;
        }
        
        .row-actions {
            margin-top: 30px;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        
        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(93, 15, 153, 0.3);
        }
        
        .action-btn i {
            font-size: 40px;
            color: #5d0f99;
            margin-bottom: 10px;
        }
        
        .action-btn span {
            font-weight: 600;
            text-align: center;
        }
    </style>
    
    <script src="/techfit/public/js/script2.js"></script>
</body>
</html>