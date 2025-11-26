<?php
session_start();

// valores antigos (repopulação após erro)
$old = $_SESSION['old_produto'] ?? [];
$erro = $_SESSION['erro_produto'] ?? null;
$sucesso = $_SESSION['sucesso_produto'] ?? null;

// limpa mensagens para não reaparecerem ao recarregar
unset($_SESSION['old_produto'], $_SESSION['erro_produto'], $_SESSION['sucesso_produto']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos - TechFit Academia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); color: #ffffff; min-height: 100vh; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { font-size: 32px; margin-bottom: 10px; color: #8a2be2; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #8a2be2; text-decoration: none; font-weight: 600; }
        .back-link:hover { text-decoration: underline; }
        .form-container { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border-radius: 15px; padding: 40px; border: 1px solid rgba(138,43,226,0.3); }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-error { background: #ff4444; color: white; }
        .alert-success { background: #00C851; color: white; }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap: 20px; margin-bottom: 20px; }
        .input-group { display:flex; flex-direction: column; }
        .input-group label { margin-bottom:8px; font-weight:600; color:#aaa; }
        .input-group input, .input-group select { padding:12px 15px; border:1px solid rgba(138,43,226,0.3); background:rgba(255,255,255,0.05); color:#fff; border-radius:8px; font-size:16px; }
        .input-group input:focus, .input-group select:focus { outline:none; border-color:#8a2be2; }
        .input-group input::placeholder { color:#666; }
        .full-width { grid-column: 1 / -1; }
        .button-row { display:flex; gap:15px; margin-top:30px; }
        .action-btn { flex:1; padding:14px; border:none; border-radius:8px; font-size:16px; font-weight:600; cursor:pointer; transition: transform .2s; }
        .action-btn:hover { transform: translateY(-2px); }
        .register-btn { background: linear-gradient(135deg,#8a2be2,#4F0064); color:#fff; }
        .cancel-btn { background:#666; color:#fff; text-align:center; text-decoration:none; line-height:50px; display:inline-block; }
        @media (max-width:768px) { .form-container { padding:20px; } .button-row { flex-direction:column; } }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/dashboard" class="back-link">← Voltar ao Dashboard</a>

        <div class="header">
            <h1>CADASTRO DE PRODUTOS</h1>
            <p>Preencha os campos abaixo para cadastrar um novo produto</p>
        </div>

        <div class="form-container">
            <?php if ($erro): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>

            <?php if ($sucesso): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($sucesso); ?></div>
            <?php endif; ?>

            <form method="POST" action="/admin/produtos/cadastrar">
                <div class="form-row">
                    <div class="input-group full-width">
                        <label for="nome_produto">Nome do Produto:</label>
                        <input type="text" id="nome_produto" name="nome_produto"
                               placeholder="Ex: Creatina 300g"
                               required
                               value="<?php echo htmlspecialchars($old['nome_produto'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label for="categoria">Categoria:</label>
                        <select id="categoria" name="categoria" required>
                            <option value="">Selecione</option>
                            <option value="Suplemento" <?php echo (isset($old['categoria']) && $old['categoria']==='Suplemento') ? 'selected' : ''; ?>>Suplemento</option>
                            <option value="Vestuário" <?php echo (isset($old['categoria']) && $old['categoria']==='Vestuário') ? 'selected' : ''; ?>>Vestuário</option>
                            <option value="Acessório" <?php echo (isset($old['categoria']) && $old['categoria']==='Acessório') ? 'selected' : ''; ?>>Acessório</option>
                            <option value="Equipamento" <?php echo (isset($old['categoria']) && $old['categoria']==='Equipamento') ? 'selected' : ''; ?>>Equipamento</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="preco">Preço (R$):</label>
                        <input type="number" id="preco" name="preco" step="0.01"
                               placeholder="Ex: 99.90" required
                               value="<?php echo htmlspecialchars($old['preco'] ?? ''); ?>">
                    </div>

                    <div class="input-group">
                        <label for="estoque">Quantidade (estoque):</label>
                        <input type="number" id="estoque" name="estoque"
                               placeholder="Ex: 50" required min="0"
                               value="<?php echo htmlspecialchars($old['estoque'] ?? ''); ?>">
                    </div>
                </div>

                <div class="button-row">
                    <button type="submit" class="action-btn register-btn">Cadastrar Produto</button>
                    <a href="/admin/dashboard" class="action-btn cancel-btn">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
