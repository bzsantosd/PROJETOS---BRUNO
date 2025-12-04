<?php
// 1. Defina o caminho para a aplicação
define('ROOT_PATH', dirname(__DIR__));
require ROOT_PATH . '/app/controllers/UserController.php';

// 2. Obtenha a URL solicitada (ex: /cadastro, /login, /perfil)
$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// 3. Roteamento simples: Decida qual Controller/Método chamar
if ($request_uri === 'cadastro') {
    // Exemplo: Instancie o Controller e chame o método
    $controller = new UserController();
    $controller->showRegisterForm(); // Mostrar a View de Cadastro
} elseif ($request_uri === 'login') {
    $controller = new UserController();
    $controller->showLoginForm();    // Mostrar a View de Login
} else {
    // Rota padrão ou erro 404
    http_response_code(404);
    echo "Página não encontrada.";
}

?>