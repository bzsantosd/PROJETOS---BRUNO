<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
    <title>Usuários</title>
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

        .msg {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .msg.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            max-width: 1100px;
            background: var(--branco);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        th, td {
            text-align: left;
            padding: 12px 14px;
            font-size: 1rem;
        }

        th {
            background-color: var(--azul);
            color: var(--branco);
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        tr:hover td {
            background: var(--verde);
            color: var(--preto);
            transition: 0.2s;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-edit {
            background: #ffc107;
            color: var(--preto);
        }

        .btn-edit:hover {
            background: #e0a800;
            transform: scale(1.05);
        }

        .btn-delete {
            background: #dc3545;
            color: var(--branco);
        }

        .btn-delete:hover {
            background: #c82333;
            transform: scale(1.05);
        }

        .btn-back {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 22px;
            border-radius: 30px;
            background: #6c757d;
            color: var(--branco);
            font-weight: bold;
            text-decoration: none;
            box-shadow: var(--shadow);
            transition: 0.3s;
        }

        .btn-back:hover {
            background: #5a6268;
            transform: scale(1.05);
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .badge-admin {
            background: #17a2b8;
            color: white;
        }

        .badge-cliente {
            background: #28a745;
            color: white;
        }
    </style>
</head>
<body>

<h1>👥 Lista de Usuários</h1>

<?php if (isset($_GET['msg'])): ?>
    <div class="msg success">
        <?php 
            if ($_GET['msg'] === 'editado') echo '✅ Usuário editado com sucesso!';
            if ($_GET['msg'] === 'deletado') echo '✅ Usuário deletado com sucesso!';
        ?>
    </div>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Tipo</th>
        <th>Cadastrado em</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($usuarios as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['nome']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td>
            <span class="badge <?= $user['tipo'] === 'admin' ? 'badge-admin' : 'badge-cliente' ?>">
                <?= ucfirst($user['tipo']) ?>
            </span>
        </td>
        <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
        <td>
            <div class="actions">
                <a href="/admin/usuarios/editar?id=<?= $user['id'] ?>" class="btn btn-edit">✏️ Editar</a>
                <a href="/admin/usuarios/deletar?id=<?= $user['id'] ?>" 
                   class="btn btn-delete" 
                   onclick="return confirm('⚠️ Tem certeza que deseja excluir o usuário <?= htmlspecialchars($user['nome']) ?>?')">
                   🗑️ Excluir
                </a>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<a href="/adm.html" class="btn-back">← Voltar ao Painel</a>

</body>
</html>