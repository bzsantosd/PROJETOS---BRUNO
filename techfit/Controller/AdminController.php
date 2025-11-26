<?php

require_once __DIR__ . '/../Models/Produto.php';
require_once __DIR__ . '/../Models/Aluno.php';

class AdminController {
    private $produtoModel;
    private $alunoModel;

    public function __construct($pdo) {
        $this->produtoModel = new Produto($pdo);
        $this->alunoModel = new Aluno($pdo);
    }

    /**
     * Verifica se o usuário é administrador
     */
    private function checarPermissao() {
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['erro_permissao'] = 'Acesso negado! Apenas administradores.';
            header('Location: /login');
            exit();
        }
    }

    /**
     * Dashboard do administrador
     */
    public function dashboard() {
        $this->checarPermissao();
        
        $produtos = $this->produtoModel->listarTodos();
        $alunos = $this->alunoModel->listarTodos();
        $relatorioCategoria = $this->produtoModel->relatorioCategoria();
        
        $totalProdutos = count($produtos);
        $totalAlunos = count($alunos);
        $valorEstoque = array_sum(array_map(function($p) {
            return $p['preco'] * $p['quantidade'];
        }, $produtos));
        $produtosBaixoEstoque = $this->produtoModel->listarBaixoEstoque(5);
        
        include __DIR__ . '/../Views/admin/dashboard.php';
    }

    // ========== PRODUTOS ==========
    
    public function exibirCadastroProduto() {
        $this->checarPermissao();
        include __DIR__ . '/../Views/admin/cadastro_produtos.php';
    }

    public function cadastrarProduto() {
        $this->checarPermissao();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->exibirCadastroProduto();
            return;
        }

        $nome = htmlspecialchars(trim($_POST['nome_produto'] ?? ''));
        $preco = (float) ($_POST['preco'] ?? 0);
        $categoria = htmlspecialchars(trim($_POST['categoria'] ?? ''));
        $quantidade = (int) ($_POST['quantidade'] ?? 0);
        $idAdministrador = $_SESSION['user_id'];

        if (empty($nome) || $preco <= 0 || empty($categoria) || $quantidade < 0) {
            $_SESSION['erro_produto'] = 'Preencha todos os campos corretamente!';
            $this->exibirCadastroProduto();
            return;
        }

        $resultado = $this->produtoModel->cadastrar(
            $nome, 
            $preco, 
            $categoria, 
            $quantidade, 
            $idAdministrador
        );

        if ($resultado['sucesso']) {
            $_SESSION['sucesso_produto'] = $resultado['mensagem'];
            header('Location: /admin/produtos');
            exit();
        } else {
            $_SESSION['erro_produto'] = $resultado['mensagem'];
            $this->exibirCadastroProduto();
        }
    }

    public function listarProdutos() {
        $this->checarPermissao();
        
        $categoria = $_GET['categoria'] ?? null;
        $produtos = $this->produtoModel->listarTodos($categoria);
        
        include __DIR__ . '/../Views/admin/lista_produtos.php';
    }

    public function exibirEdicaoProduto($id) {
        $this->checarPermissao();
        
        $produto = $this->produtoModel->buscarPorId($id);
        
        if (!$produto) {
            $_SESSION['erro_produto'] = 'Produto não encontrado!';
            header('Location: /admin/produtos');
            exit();
        }
        
        include __DIR__ . '/../Views/admin/editar_produto.php';
    }

    public function editarProduto($id) {
        $this->checarPermissao();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->exibirEdicaoProduto($id);
            return;
        }

        $nome = htmlspecialchars(trim($_POST['nome_produto'] ?? ''));
        $preco = (float) ($_POST['preco'] ?? 0);
        $categoria = htmlspecialchars(trim($_POST['categoria'] ?? ''));
        $quantidade = (int) ($_POST['quantidade'] ?? 0);

        $resultado = $this->produtoModel->atualizar($id, $nome, $preco, $categoria, $quantidade);

        if ($resultado['sucesso']) {
            $_SESSION['sucesso_produto'] = $resultado['mensagem'];
            header('Location: /admin/produtos');
            exit();
        } else {
            $_SESSION['erro_produto'] = $resultado['mensagem'];
            $this->exibirEdicaoProduto($id);
        }
    }

    public function removerProduto($id) {
        $this->checarPermissao();
        
        if ($this->produtoModel->remover($id)) {
            $_SESSION['sucesso_produto'] = 'Produto removido com sucesso!';
        } else {
            $_SESSION['erro_produto'] = 'Erro ao remover produto!';
        }
        
        header('Location: /admin/produtos');
        exit();
    }

    // ========== ALUNOS ==========
    
    public function listarAlunos() {
        $this->checarPermissao();
        
        $alunos = $this->alunoModel->listarTodos();
        include __DIR__ . '/../Views/admin/lista_alunos.php';
    }

    public function verAluno($id) {
        $this->checarPermissao();
        
        $aluno = $this->alunoModel->buscarPorId($id);
        
        if (!$aluno) {
            $_SESSION['erro_aluno'] = 'Aluno não encontrado!';
            header('Location: /admin/alunos');
            exit();
        }
        
        include __DIR__ . '/../Views/admin/detalhes_aluno.php';
    }

    public function removerAluno($id) {
        $this->checarPermissao();
        
        if ($this->alunoModel->remover($id)) {
            $_SESSION['sucesso_aluno'] = 'Aluno removido com sucesso!';
        } else {
            $_SESSION['erro_aluno'] = 'Erro ao remover aluno!';
        }
        
        header('Location: /admin/alunos');
        exit();
    }
}
?>