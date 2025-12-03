<!DOCTYPE html>
<html lang="pt-BR">
  <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
<head>
  <meta charset="UTF-8">
<title>Planos</title>
</head>
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

/* RESET */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", Roboto, sans-serif;
}

html, body {
  height: 100%;
}

/* FUNDO */
body {
  background: #1d1d1dc2;
  backdrop-filter: blur(10px);
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 50px 10px;
}

/* TÍTULO */
h1 {
  font-size: 2.5rem;
  color: var(--verde);
  font-weight: 900;
  margin-bottom: 30px;
  text-align: center;
}

/* TABELA */
table {
  border-collapse: collapse;
  width: 100%;
  max-width: 900px;
  background: var(--branco);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: var(--shadow);
}

th, td {
  text-align: left;
  padding: 10px 14px;
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

/* BOTÃO VOLTAR */
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

    </style>


<body>

<h1>Gerenciar Planos</h1>
<a href="/admin/planos/novo">+ Novo Produto</a><br><br>

<table border="1" cellpadding="6">
<tr><th>ID</th><th>Titulo</th><th>Valor</th><th>Beneficios</th><th>Ações</th></tr>

<?php foreach ($planos as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= $p['titulo'] ?></td>
    <td>R$ <?= number_format($p['valor'], 2, ',', '.') ?></td>
    <td><?= $p['beneficios'] ?></td>
    <td>
        <a href="/admin/planos/editar?id=<?= $p['id'] ?>">✏️</a>
        <a  href="/admin/planos/deletar?id=<?= $p['id'] ?>" onclick="return confirm('Excluir plano?')">🗑</a>
    </td>
</tr>
<?php endforeach; ?>

</table>
<br>
<a href="/adm.html">Voltar</a>

</body>
</html>
