<?php
if (isset($erro)) {
    echo "<p style='color: red;'>$erro</p>";
}
?>

<h2>Cadastrar Novo Produto</h2>

<form method="POST" action="/admin/produtos/cadastrar">
    <label for="nome_produto">Nome:</label>
    <input type="text" id="nome_produto" name="nome_produto" required><br><br>

    <label for="preco">Preço:</label>
    <input type="number" step="0.01" id="preco" name="preco" required><br><br>

    <label for="categoria">Categoria:</label>
    <input type="text" id="categoria" name="categoria" required><br><br>

    <label for="quantidade">Quantidade:</label>
    <input type="number" id="quantidade" name="quantidade" required><br><br>

    <button type="submit">Salvar Produto</button>
</form>