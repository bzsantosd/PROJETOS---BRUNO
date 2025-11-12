<?php
// index.php (Front Controller) - Lógica de Roteamento Simples

// 1. Inclui o arquivo de conexão PDO
require_once 'Config/Database.php'; 
require_once 'Controller/AdminController.php';
require_once 'Model/Produto.php';

// Define a URL solicitada (ex: /admin/produtos/cadastrar)
$request_uri = trim($_SERVER['REQUEST_URI'], '/');
$segments = explode('/', $request_uri);

if ($segments[0] === 'admin' && $segments[1] === 'produtos' && $segments[2] === 'cadastrar') {
    // 2. Cria a instância do Controller (passando a conexão PDO)
    $controller = new AdminController($pdo); 
    
    // 3. Chama a ação de cadastro
    $controller->cadastroProdutos();
} 
// ... adicionar outras rotas ...
?>