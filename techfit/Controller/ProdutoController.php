<?php
// Controller/ProdutoController.php

require_once __DIR__ . '/../Model/Produto.php';
require_once __DIR__ . '/../Config/Database.php';

use Techfit\Config\Connection;

class ProdutoController {
    private $produtoModel;

    public function __construct() {
        $pdo = Connection::getInstance();
        $this->produtoModel = new Produto($pdo);
    }

    /**
     * Exibe formulário de cadastro de produto
     */
    public function exibirFormularioCadastro() {
        session_start();
        
        // Verifica se está logado como admin
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }

        include __DIR__ . '/../View/admin/cadastro_produtos.php';
    }

    /**
     * Processa cadastro de produto
     */
    public function cadastrar() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/produtos/cadastrar');
            exit();
        }

        // Valida se está logado como admin
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }

        $nome = trim($_POST['nome_produto'] ?? '');
        $preco = floatval($_POST['preco'] ?? 0);
        $categoria = trim($_POST['categoria'] ?? '');
        $quantidade = intval($_POST['quantidade'] ?? 0);
        $idAdministrador = $_SESSION['user_id'];

        // Validações
        if (empty($nome) || empty($categoria) || $preco <= 0) {
            $_SESSION['erro_produto'] = 'Preencha todos os campos corretamente!';
            header('Location: /admin/produtos/cadastrar');
            exit();
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
        } else {
            $_SESSION['erro_produto'] = $resultado['mensagem'];
            header('Location: /admin/produtos/cadastrar');
        }
        exit();
    }

    /**
     * Lista todos os produtos
     */
    public function listar() {
        session_start();

        if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }

        $filtroCategoria = $_GET['categoria'] ?? null;
        $produtos = $this->produtoModel->listarTodos($filtroCategoria);

        include __DIR__ . '/../View/admin/lista_produtos.php';
    }

    /**
     * Exibe formulário de edição
     */
    public function exibirFormularioEdicao($id) {
        session_start();

        if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }

        $produto = $this->produtoModel->buscarPorId($id);

        if (!$produto) {
            $_SESSION['erro_produto'] = 'Produto não encontrado!';
            header('Location: /admin/produtos');
            exit();
        }

        include __DIR__ . '/../View/admin/editar_produto.php';
    }

    /**
     * Processa atualização de produto
     */
    public function atualizar($id) {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/produtos');
            exit();
        }

        if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }

        $nome = trim($_POST['nome_produto'] ?? '');
        $preco = floatval($_POST['preco'] ?? 0);
        $categoria = trim($_POST['categoria'] ?? '');
        $quantidade = intval($_POST['quantidade'] ?? 0);

        if (empty($nome) || empty($categoria) || $preco <= 0) {
            $_SESSION['erro_produto'] = 'Preencha todos os campos corretamente!';
            header('Location: /admin/produtos/editar/' . $id);
            exit();
        }

        $resultado = $this->produtoModel->atualizar($id, $nome, $preco, $categoria, $quantidade);

        if ($resultado['sucesso']) {
            $_SESSION['sucesso_produto'] = $resultado['mensagem'];
        } else {
            $_SESSION['erro_produto'] = $resultado['mensagem'];
        }

        header('Location: /admin/produtos');
        exit();
    }

    /**
     * Remove produto
     */
    public function remover($id) {
        session_start();

        if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }

        $resultado = $this->produtoModel->remover($id);

        if ($resultado) {
            $_SESSION['sucesso_produto'] = 'Produto removido com sucesso!';
        } else {
            $_SESSION['erro_produto'] = 'Erro ao remover produto.';
        }

        header('Location: /admin/produtos');
        exit();
    }

    /**
     * Atualiza estoque de produto
     */
    public function atualizarEstoque($id) {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/produtos');
            exit();
        }

        if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }

        $quantidade = intval($_POST['quantidade'] ?? 0);
        
        $resultado = $this->produtoModel->atualizarEstoque($id, $quantidade);

        if ($resultado) {
            $_SESSION['sucesso_produto'] = 'Estoque atualizado!';
        } else {
            $_SESSION['erro_produto'] = 'Erro ao atualizar estoque.';
        }

        header('Location: /admin/produtos');
        exit();
    }
}