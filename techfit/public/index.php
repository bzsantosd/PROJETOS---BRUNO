=<?php
// public/index.php - Front Controller

// Inicia a sessão
session_start();

// Autoload de classes
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../Config/' . $class . '.php',
        __DIR__ . '/../Model/' . $class . '.php',
        __DIR__ . '/../Controller/' . $class . '.php',
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Configuração de erros (desabilite em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexão com banco de dados
$database = new Database();
$pdo = $database->getConnection();

// Obtém a URL requisitada
$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $request_uri);

// Roteamento simples
try {
    // Rota padrão: redireciona para login
    if (empty($segments[0])) {
        header('Location: /login');
        exit();
    }

    // ========== ROTAS DE AUTENTICAÇÃO ==========
    if ($segments[0] === 'login') {
        $controller = new AuthController($pdo);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->exibirLogin();
        }
        exit();
    }

    if ($segments[0] === 'cadastro') {
        $controller = new AuthController($pdo);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->cadastrar();
        } else {
            $controller->exibirCadastro();
        }
        exit();
    }

    if ($segments[0] === 'esqueceu-senha') {
        $controller = new AuthController($pdo);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->recuperarSenha();
        } else {
            $controller->exibirEsqueceuSenha();
        }
        exit();
    }

    if ($segments[0] === 'logout') {
        $controller = new AuthController($pdo);
        $controller->logout();
        exit();
    }

    // ========== ROTAS DE ADMINISTRADOR ==========
    if ($segments[0] === 'admin') {
        $adminController = new AdminController($pdo);
        
        // /admin/dashboard
        if (!isset($segments[1]) || $segments[1] === 'dashboard') {
            $adminController->dashboard();
            exit();
        }

        // /admin/alunos
        if ($segments[1] === 'alunos') {
            
            // /admin/alunos/ver/123
            if (isset($segments[2]) && $segments[2] === 'ver' && isset($segments[3])) {
                $idAluno = (int) $segments[3];
                $adminController->verAluno($idAluno);
                exit();
            }
            
            // /admin/alunos/remover/123
            if (isset($segments[2]) && $segments[2] === 'remover' && isset($segments[3])) {
                $idAluno = (int) $segments[3];
                $adminController->removerAluno($idAluno);
                exit();
            }
            
            // /admin/alunos (listagem)
            $adminController->listarAlunos();
            exit();
        }

        // /admin/produtos
        if ($segments[1] === 'produtos') {
            
            // /admin/produtos/cadastrar
            if (isset($segments[2]) && $segments[2] === 'cadastrar') {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $adminController->cadastrarProduto();
                } else {
                    $adminController->exibirCadastroProduto();
                }
                exit();
            }
            
            // /admin/produtos/editar/123
            if (isset($segments[2]) && $segments[2] === 'editar' && isset($segments[3])) {
                $idProduto = (int) $segments[3];
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $adminController->editarProduto($idProduto);
                } else {
                    $adminController->exibirEdicaoProduto($idProduto);
                }
                exit();
            }
            
            // /admin/produtos/remover/123
            if (isset($segments[2]) && $segments[2] === 'remover' && isset($segments[3])) {
                $idProduto = (int) $segments[3];
                $adminController->removerProduto($idProduto);
                exit();
            }
            
            // /admin/produtos (listagem)
            $adminController->listarProdutos();
            exit();
        }
    }

    // ========== ROTA NÃO ENCONTRADA ==========
    http_response_code(404);
    echo "<h1>404 - Página não encontrada</h1>";
    echo "<p><a href='/login'>Voltar ao Login</a></p>";

} catch (Exception $e) {
    // Tratamento de erros
    error_log("Erro no roteamento: " . $e->getMessage());
    http_response_code(500);
    echo "<h1>Erro interno do servidor</h1>";
    echo "<p>Por favor, tente novamente mais tarde.</p>";
}
?>