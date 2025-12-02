<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Editar Usuário</title>
    <style>
        :root {
            --azul: #007bff;
            --preto: #000000;
            --cinza: #2c2c2c;
            --branco: #ffffff;
            --verde: #a6ff00;
            --radius: 16px;
            --shadow: 0 8px 32px rgba(0,0,0,0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Roboto, sans-serif;
        }

        html, body {
            height: 100%;
        }

        body {
            background: #1d1d1dc2;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 50px 10px;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--verde);
            font-weight: 900;
            margin-bottom: 30px;
            text-align: center;
        }

        form {
            width: 100%;
            max-width: 600px;
            background: var(--branco);
            padding: 25px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        form label {
            font-weight: bold;
            color: var(--preto);
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        form input,
        form select {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 2px solid var(--azul);
            margin-bottom: 18px;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
            background: #f7f7f7;
        }

        form input:focus,
        form select:focus {
            border-color: var(--verde);
            background: #ffffff;
        }

        form button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: var(--azul);
            color: var(--branco);
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        form button:hover {
            background: var(--verde);
            color: var(--preto);
            transform: scale(1.03);
        }

        a {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 22px;
            border-radius: 30px;
            background: #ff4d4d;
            color: var(--branco);
            font-weight: bold;
            text-decoration: none;
            box-shadow: var(--shadow);
            transition: 0.3s;
        }

        a:hover {
            background: #e60000;
            transform: scale(1.05);
        }

        .info {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<h1>Editar Usuário</h1>

<form action="/admin/usuarios/salvar" method="post">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

    <label for="tipo">Tipo de Usuário:</label>
    <select id="tipo" name="tipo" required>
        <option value="cliente" <?= $usuario['tipo'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
        <option value="admin" <?= $usuario['tipo'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
    </select>

    <div class="info">
        💡 Deixe a senha em branco para manter a senha atual
    </div>

    <label for="senha">Nova Senha (opcional):</label>
    <input type="password" id="senha" name="senha" placeholder="Deixe em branco para não alterar">

    <button type="submit">💾 Salvar Alterações</button>
</form>

<a href="/admin/usuarios">← Voltar</a>

</body>
</html>