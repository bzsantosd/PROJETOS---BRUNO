<!DOCTYPE html>
<html lang="pt-BR">
    <link rel="shortcut icon" href="https://github.com/mariamaed29/Projeto.Techfit/blob/main/FOTOS/logoNormal.png?raw=true" type="image/x-icon">
<head>
    <meta charset="UTF-8"><title>Editar Planos</title>

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

/* CONTAINER DO FORM */
form {
  width: 100%;
  max-width: 600px;
  background: var(--branco);
  padding: 25px;
  border-radius: 12px;
  box-shadow: var(--shadow);
}

/* LABELS */
form label {
  font-weight: bold;
  color: var(--preto);
  display: block;
  margin-bottom: 5px;
  font-size: 1rem;
}

/* INPUTS E TEXTAREA */
form input,
form textarea {
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

form textarea {
  height: 110px;
  resize: none;
}

form input:focus,
form textarea:focus {
  border-color: var(--verde);
  background: #ffffff;
}

/* BOTÃO SALVAR */
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

<h1>Editar Plano</h1>
<form action="/admin/planos/salvar" method="post">
    <input type="hidden" name="id" value="<?= $plano['id'] ?>">

    Titulo: <input name="titulo" value="<?= $plano['titulo'] ?>" required><br><br>
    Valor: <input type="number" step="0.01" name="valor" value="<?= $plano['valor'] ?>" required><br><br>
    Beneficios: <textarea name="beneficios"><?= $plano['beneficios'] ?></textarea><br><br>
    <button type="submit">Salvar</button>
</form>
<br>
<a href="/admin/planos">Voltar</a>

</body>
</html>
