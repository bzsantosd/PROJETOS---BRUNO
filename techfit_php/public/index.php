<?php
// public/index.php - Ponto de entrada único da aplicação

// Inicia a sessão
session_start();

// Define o caminho base
define('BASE_PATH', dirname(__DIR__));

// Autoload simples para os controllers
spl_autoload_register(function($class) {
    $paths = [
        BASE_PATH . '/app/controllers/' . $class . '.php',
        BASE_PATH . '/app/models/' . $class . '.php',
        BASE_PATH . '/core/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Obtém a URL solicitada
$url = $_SERVER['REQUEST_URI'];
$url = str_replace('/techfit/', '', $url); // Remove o prefixo do projeto
$url = parse_url($url, PHP_URL_PATH);
$url = trim($url, '/');

// Se a URL estiver vazia, redireciona para login
if (empty($url)) {
    $url = 'login';
}

// Sistema de rotas
switch ($url) {
    
    // ============= ROTAS DE AUTENTICAÇÃO =============
    case 'login':
        $controller = new UsuarioController();
        $controller->mostrarLogin();
        break;
        
    case 'login/processar':
        $controller = new UsuarioController();
        $controller->processarLogin();
        break;
        
    case 'cadastro':
        $controller = new UsuarioController();
        $controller->mostrarCadastro();
        break;
        
    case 'cadastro/processar':
        $controller = new UsuarioController();
        $controller->processarCadastro();
        break;
        
    case 'logout':
        $controller = new UsuarioController();
        $controller->logout();
        break;
    
    // ============= ROTAS PÚBLICAS =============
    case 'home':
    case '':
        require_once BASE_PATH . '/app/views/home/index.php';
        break;
        
    case 'produtos':
        $controller = new ProdutoController();
        $controller->listar();
        break;
        
    case (preg_match('/^produtos\/(\d+)$/', $url, $matches) ? true : false):
        $controller = new ProdutoController();
        $controller->detalhes($matches[1]);
        break;
    
    // ============= ROTAS ADMINISTRATIVAS =============
    case 'admin':
    case 'admin/dashboard':
        $controller = new AdminController();
        $controller->dashboard();
        break;
        
    case 'admin/usuarios':
        $controller = new AdminController();
        $controller->listarUsuarios();
        break;
        
    case 'admin/produtos':
        $controller = new AdminController();
        $controller->listarProdutos();
        break;
        
    case 'admin/produtos/cadastrar':
        $controller = new ProdutoController();
        $controller->mostrarFormularioCadastro();
        break;
        
    case 'admin/produtos/salvar':
        $controller = new ProdutoController();
        $controller->cadastrar();
        break;
        
    case (preg_match('/^admin\/produtos\/editar\/(\d+)$/', $url, $matches) ? true : false):
        $controller = new ProdutoController();
        $controller->mostrarFormularioEdicao($matches[1]);
        break;
        
    case (preg_match('/^admin\/produtos\/atualizar\/(\d+)$/', $url, $matches) ? true : false):
        $controller = new ProdutoController();
        $controller->atualizar($matches[1]);
        break;
        
    case (preg_match('/^admin\/produtos\/deletar\/(\d+)$/', $url, $matches) ? true : false):
        $controller = new ProdutoController();
        $controller->deletar($matches[1]);
        break;
        
    case 'admin/relatorio-vendas':
        $controller = new AdminController();
        $controller->relatorioVendas();
        break;
        
    case 'admin/fluxo-alunos':
        $controller = new AdminController();
        $controller->fluxoAlunos();
        break;
        
    case 'admin/configuracoes':
        $controller = new AdminController();
        $controller->configuracoes();
        break;
    
    // ============= ROTA 404 =============
    default:
        http_response_code(404);
        echo "<h1>Página não encontrada</h1>";
        echo "<a href='/techfit/'>Voltar para o início</a>";
        break;
}