<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

// Exibe erros em desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../controllers/',
        __DIR__ . '/../models/',
        __DIR__ . '/../core/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

if (preg_match('/\.html$/', $uri)) {
    $filePath = __DIR__ . '/../' . $uri; // Busca na pasta pai
    
    if (file_exists($filePath)) {
        header('Content-Type: text/html; charset=UTF-8');
        readfile($filePath);
        exit;
    }
}
// Raiz
if ($uri === "/") {
    header("Location: /Login.html");
    exit;
}

// Login
if ($uri === "/login" && $method === "POST") {
    $controller = new UsuarioController();
    $controller->login();
}

// Cadastro
if ($uri === "/cadastro" && $method === "POST") {
    $controller = new UsuarioController();
    $controller->cadastro();
}

// Logout
if ($uri === "/logout") {
    $controller = new UsuarioController();
    $controller->logout();
}

// Produtos
if ($uri === "/produtos") {
    $controller = new ProdutoController();
    $controller->listarJson();
}

// Rotas Admin
if (strpos($uri, '/admin') === 0) {
    if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
        http_response_code(403);
        die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
    }
    
    if ($uri === "/admin/usuarios") {
        $controller = new AdminController();
        $controller->listarUsuarios();
        exit;
    }
    
    if ($uri === "/admin/usuarios/deletar" && isset($_GET['id'])) {
        $controller = new AdminController();
        $controller->deletarUsuario($_GET['id']);
    }

        if ($uri === "/admin/usuarios/editar" && isset($_GET['id'])) {
        $controller = new AdminController();
        $controller->editarUsuarioForm(id: $_GET['id']);
        exit;
    }
    
    if ($uri === "/admin/usuarios/salvar" && $method === "POST") {
        $controller = new AdminController();
        $controller->editarUsuarioSalvar();
    }
    
    
// =========================================================================
// Rotas Produtos
    if ($uri === "/admin/produtos") {
        $controller = new ProdutoController();
        $controller->listar();
        exit;
    }
    
    if ($uri === "/admin/produtos/novo") {
        $controller = new ProdutoController();
        $controller->novo();
        exit;
    }
    
    if ($uri === "/admin/produtos/criar" && $method === "POST") {
        $controller = new ProdutoController();
        $controller->criar();
    }
    
    if ($uri === "/admin/produtos/editar" && isset($_GET['id'])) {
        $controller = new ProdutoController();
        $controller->editarForm($_GET['id']);
        exit;
    }
    
    if ($uri === "/admin/produtos/salvar" && $method === "POST") {
        $controller = new ProdutoController();
        $controller->editarSalvar();
    }
    
    if ($uri === "/admin/produtos/deletar" && isset($_GET['id'])) {
        $controller = new ProdutoController();
        $controller->deletar($_GET['id']);
    }

// =========================================================================
// Rotas Planos
    if ($uri === "/admin/planos") {
        $controller = new PlanoController();
        $controller->listar();
        exit;
    }
    
    if ($uri === "/admin/planos/novo") {
        $controller = new PlanoController();
        $controller->novo();
        exit;
    }
    
    if ($uri === "/admin/planos/criar" && $method === "POST") {
        $controller = new PlanoController();
        $controller->criar();
    }
    
    if ($uri === "/admin/planos/editar" && isset($_GET['id'])) {
        $controller = new PlanoController();
        $controller->editarForm($_GET['id']);
        exit;
    }
    
    if ($uri === "/admin/planos/salvar" && $method === "POST") {
        $controller = new PlanoController();
        $controller->editarSalvar();
    }
    
    if ($uri === "/admin/planos/deletar" && isset($_GET['id'])) {
        $controller = new PlanoController();
        $controller->deletar($_GET['id']);
    }
}

// 404
http_response_code(404);
echo "<h1>404 - Página não encontrada</h1>";
echo "<p>Rota: <strong>{$uri}</strong></p>";
echo "<a href='/'>Voltar</a>";