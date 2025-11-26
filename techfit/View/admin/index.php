<?php
session_start();

// Autoload das classes (ajustado para apontar à raiz do projeto)
spl_autoload_register(function ($class) {
    $prefix = 'Techfit\\';
    if (strpos($class, $prefix) !== 0) {
        return;
    }

    // baseDir = raiz do projeto (dois níveis acima de View/admin)
    $baseDir = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;
    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $file = $baseDir . $relative . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// base do projeto para requires relativos
$baseDir = realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR;

// Importar conexão (classe em namespace Techfit\Config)
use Techfit\Config\Connection;

// Traçar a URL
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = str_replace('/index.php', '', $url);
$url = trim($url, '/');

// Dividir rota
$partes = array_values(array_filter(explode('/', $url), fn($p) => $p !== ''));

// Pegar controller e ação
$controller = $partes[0] ?? 'home';
$acao = $partes[1] ?? 'index';
$sub1 = $partes[2] ?? null;
$sub2 = $partes[3] ?? null;
$id = $partes[2] ?? null; // compatibilidade com rotas que usam /controller/action/{id}

// Conectar ao banco
$pdo = Connection::getInstance();

// ROTEAMENTO
try {
    switch ($controller) {

        // ===== AUTENTICAÇÃO =====
        case 'login':
            require_once $baseDir . 'app/Controllers/AuthController.php';
            $auth = new AuthController($pdo);
            if ($acao === 'sair' || $acao === 'logout') {
                $auth->logout();
            } else {
                $auth->login();
            }
            break;

        case 'cadastro':
            require_once $baseDir . 'app/Controllers/AuthController.php';
            $auth = new AuthController($pdo);
            $auth->cadastrar();
            break;

        case 'esqueceu-senha':
            require_once $baseDir . 'app/Controllers/AuthController.php';
            $auth = new AuthController($pdo);
            $auth->recuperarSenha();
            break;

        case 'logout':
            require_once $baseDir . 'app/Controllers/AuthController.php';
            $auth = new AuthController($pdo);
            $auth->logout();
            break;

        // ===== ADMIN =====
        case 'admin':
            if (!isset($_SESSION['usuario_logado']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
                header('Location: /login');
                exit();
            }

            require_once $baseDir . 'app/Controllers/AdminController.php';
            $admin = new AdminController($pdo);

            if ($acao === 'dashboard') {
                $admin->dashboard();
            } elseif ($acao === 'alunos') {
                if ($sub1 === 'remover') {
                    $admin->removerAluno($sub2);
                } elseif ($sub1 === 'ver') {
                    $admin->verAluno($sub2);
                } else {
                    $admin->listarAlunos();
                }
            } elseif ($acao === 'produtos') {
                if ($sub1 === 'cadastrar') {
                    $admin->cadastrarProduto();
                } elseif ($sub1 === 'editar') {
                    $admin->editarProduto($sub2);
                } elseif ($sub1 === 'remover') {
                    $admin->removerProduto($sub2);
                } else {
                    $admin->listarProdutos();
                }
            } else {
                // rota admin padrão
                $admin->dashboard();
            }
            break;

        // ===== ALUNO =====
        case 'aluno':
            if (!isset($_SESSION['usuario_logado']) || ($_SESSION['user_role'] ?? '') !== 'aluno') {
                header('Location: /login');
                exit();
            }

            require_once $baseDir . 'app/Controllers/AlunoController.php';
            $aluno = new AlunoController($pdo);

            if ($acao === 'dashboard') {
                $aluno->dashboard();
            } elseif ($acao === 'planos') {
                $aluno->verPlanos();
            } elseif ($acao === 'meus-planos') {
                $aluno->meusPlanos();
            } elseif ($acao === 'comprar-plano') {
                $aluno->comprarPlano($id);
            } elseif ($acao === 'loja') {
                $aluno->loja();
            } elseif ($acao === 'minhas-compras') {
                $aluno->minhasCompras();
            } else {
                $aluno->dashboard();
            }
            break;

        default:
            if (isset($_SESSION['usuario_logado'])) {
                if (($_SESSION['user_role'] ?? '') === 'admin') {
                    header('Location: /admin/dashboard');
                } else {
                    header('Location: /aluno/dashboard');
                }
                exit();
            }
            header('Location: /login');
            exit();
    }
} catch (Exception $e) {
    // evitar revelar stack em produção
    error_log('index.php erro: ' . $e->getMessage());
    echo "Ocorreu um erro. Verifique o log do servidor.";
}
?>
