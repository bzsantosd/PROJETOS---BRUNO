<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos - TechFit Academia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
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
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #8a2be2;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #8a2be2;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px;
            border: 1px solid rgba(138, 43, 226, 0.3);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #ff4444;
            color: white;
        }

        .alert-success {
            background: #00C851;
            color: white;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #aaa;
        }

        .input-group input,
        .input-group select {
            padding: 12px 15px;
            border: 1px solid rgba(138, 43, 226, 0.3);
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-radius: 8px;
            font-size: 16px;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #8a2be2;
        }

        .input-group input::placeholder {
            color: #666;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .button-row {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .action-btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .register-btn {
            background: linear-gradient(135deg, #8a2be2, #4F0064);
            color: white;
        }

        .cancel-btn {
            background: #666;
            color: white;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .button-row {
                flex-direction: column;
            }
        }
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
            <?php
            if (isset($_SESSION['erro_produto'])) {
                echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['erro_produto']) . '</div>';
                unset($_SESSION['erro_produto']);
            }
            ?>

            <form method="POST" action="/admin/produtos/cadastrar">
                <div class="form-row">
                    <div class="input-group full-width">
                        <label for="nome_produto">Nome do Produto:</label>
                        <input type="text" id="nome_produto" name="nome_produto" 
                               placeholder="Ex: Creatina 300g" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label for="categoria">Categoria:</label>
                        <select id="categoria" name="categoria" required>
                            <option value="">Selecione</option>
                            <option value="Suplemento">Suplemento</option>
                            <option value="Vestuário">Vestuário</option>
                            <option value="Acessório">Acessório</option>
                            <option value="Equipamento">Equipamento</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="preco">Preço (R$):</label>
                        <input type="number" id="preco" name="preco" step="0.01" 
                               placeholder="Ex: 99.90" required>
                    </div>

                    <div class="input-group">
                        <label for="quantidade">Quantidade:</label>
                        <input type="number" id="quantidade" name="quantidade" 
                               placeholder="Ex: 50" required min="0">
                    </div>
                </div>

                <div class="button-row">
                    <button type="submit" class="action-btn register-btn">Cadastrar Produto</button>
                    <a href="/admin/dashboard" class="action-btn cancel-btn" 
                       style="text-align: center; text-decoration: none; line-height: 50px;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>