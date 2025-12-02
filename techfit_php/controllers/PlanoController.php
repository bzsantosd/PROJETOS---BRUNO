<?php
require_once __DIR__ . '/../models/PlanosModel.php';

class PlanoController {
    private $model;
    
    public function __construct() {
        $this->model = new PlanosModel();
    }
    
    private function requireAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['tipo'] !== 'admin') {
            die("Acesso negado! <a href='/Login.html'>Fazer login</a>");
        }
    }
    
    public function listar() {
        $this->requireAdmin();
        $planos = $this->model->buscarTodos();
        include __DIR__ . '/../views/admin/listaPlanos.php';
    }
    
    public function novo() {
        $this->requireAdmin();
        include __DIR__ . '/../views/admin/novoPlanos.php';
    }
    
    public function criar() {
        $this->requireAdmin();
        
        $titulo = $_POST['titulo'] ?? '';
        $valor = $_POST['valor'] ?? 0;
        $beneficio = $_POST['beneficio'] ?? '';
        
        if ($this->model->criar($titulo, $valor, $beneficio)) {
            header("Location: /admin/planos?msg=criado");
        } else {
            die("Erro ao criar plano!");
        }
        exit;
    }
    
    public function editarForm($id) {
        $this->requireAdmin();
        $produto = $this->model->buscarPorId($id);
        
        if (!$produto) {
            die("Produto não encontrado!");
        }
        
        include __DIR__ . '/../views/admin/editarPlanos.php';
    }
    
    public function editarSalvar() {
        $this->requireAdmin();
        
        $id = $_POST['id'] ?? 0;
        $titulo = $_POST['titulo'] ?? '';
        $valor = $_POST['valor'] ?? 0;
        $beneficio = $_POST['beneficio'] ?? '';
        
        
        if ($this->model->editar($id, $titulo, $valor, $beneficio)) {
            header("Location: /admin/planos?msg=editado");
        } else {
            die("Erro ao editar produto!");
        }
        exit;
    }
    
    public function deletar($id) {
        $this->requireAdmin();
        
        if ($this->model->deletar($id)) {
            header("Location: /admin/planos?msg=deletado");
        } else {
            die("Erro ao deletar plano!");
        }
        exit;
    }
    
    public function listarJson() {
        $planos = $this->model->buscarTodos();
        header('Content-Type: application/json');
        echo json_encode($planos);
        exit;
    }
}
?>