<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController {
    private $model;
    
    public function __construct() {
        $this->model = new ProductModel();
    }
    
    private function requireAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
    }
    
    public function listar() {
        $this->requireAdmin();
        $produtos = $this->model->buscarTodos();
        include __DIR__ . '/../views/admin/listaProdutos.php';
    }
    
    public function novo() {
        $this->requireAdmin();
        include __DIR__ . '/../views/admin/novoProduto.php';
    }
    
    public function criar() {
        $this->requireAdmin();
        
        $nome = $_POST['nome'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $descricao = $_POST['descricao'] ?? '';
        $imagem = $_POST['imagem'] ?? '';
        
        if ($this->model->criar($nome, $preco, $descricao, $imagem)) {
            header("Location: /admin/produtos?msg=criado");
        } else {
            die("Erro ao criar produto!");
        }
        exit;
    }
    
    public function editarForm($id) {
        $this->requireAdmin();
        $produto = $this->model->buscarPorId($id);
        
        if (!$produto) {
            die("Produto não encontrado!");
        }
        
        include __DIR__ . '/../views/admin/editarProduto.php';
    }
    
    public function editarSalvar() {
        $this->requireAdmin();
        
        $id = $_POST['id'] ?? 0;
        $nome = $_POST['nome'] ?? '';
        $preco = $_POST['preco'] ?? 0;
        $descricao = $_POST['descricao'] ?? '';
        $imagem = $_POST['imagem'] ?? '';
        
        
        if ($this->model->editar($id, $nome, $preco, $descricao, $imagem)) {
            header("Location: /admin/produtos?msg=editado");
        } else {
            die("Erro ao editar produto!");
        }
        exit;
    }
    
    public function deletar($id) {
        $this->requireAdmin();
        
        if ($this->model->deletar($id)) {
            header("Location: /admin/produtos?msg=deletado");
        } else {
            die("Erro ao deletar produto!");
        }
        exit;
    }
    
    public function listarJson() {
        $produtos = $this->model->buscarTodos();
        header('Content-Type: application/json');
        echo json_encode($produtos);
        exit;
    }
}
?>