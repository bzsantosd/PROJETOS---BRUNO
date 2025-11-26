<?php

require_once __DIR__ . '/../Models/Aluno.php';
require_once __DIR__ . '/../Models/Produto.php';
require_once __DIR__ . '/../Models/Plano.php';
require_once __DIR__ . '/../Models/Compra.php';

class AlunoController {
    private $alunoModel;
    private $produtoModel;
    private $planoModel;
    private $compraModel;

    public function __construct($pdo) {
        $this->alunoModel = new Aluno($pdo);
        $this->produtoModel = new Produto($pdo);
        $this->planoModel = new Plano($pdo);
        $this->compraModel = new Compra($pdo);
    }

    private function checarPermissao() {
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['user_role'] !== 'aluno') {
            header('Location: /login');
            exit();
        }
    }

    public function dashboard() {
        $this->checarPermissao();
        
        $idAluno = $_SESSION['user_id'];
        $aluno = $this->alunoModel->buscarPorId($idAluno);
        $planoAtivo = $this->planoModel->obterPlanoAtivo($idAluno);
        $ultimasCompras = $this->compraModel->listarCompras($idAluno, 5);
        $totalGasto = $this->compraModel->totalGasto($idAluno);
        
        include __DIR__ . '/../Views/aluno/dashboard.php';
    }

    public function verPlanos() {
        $this->checarPermissao();
        
        $planos = $this->planoModel->listarPlanos();
        $planoAtivo = $this->planoModel->obterPlanoAtivo($_SESSION['user_id']);
        
        include __DIR__ . '/../Views/aluno/planos.php';
    }

    public function comprarPlano($idPlano) {
        $this->checarPermissao();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /aluno/planos');
            exit();
        }

        $idAluno = $_SESSION['user_id'];
        $plano = $this->planoModel->buscarPorId($idPlano);

        if (!$plano) {
            $_SESSION['erro_plano'] = 'Plano não encontrado!';
            header('Location: /aluno/planos');
            exit();
        }

        $resultado = $this->planoModel->assinar($idAluno, $idPlano);

        if ($resultado['sucesso']) {
            $_SESSION['sucesso_plano'] = 'Plano contratado com sucesso!';
            header('Location: /aluno/meus-planos');
        } else {
            $_SESSION['erro_plano'] = $resultado['mensagem'];
            header('Location: /aluno/planos');
        }
        exit();
    }

    public function meusPlanos() {
        $this->checarPermissao();
        
        $idAluno = $_SESSION['user_id'];
        $assinaturas = $this->planoModel->listarAssinaturas($idAluno);
        
        include __DIR__ . '/../Views/aluno/meus_planos.php';
    }

    public function loja() {
        $this->checarPermissao();
        
        $produtos = $this->produtoModel->ListarTodos();
        $categoria = $_GET['categoria'] ?? null;
        
        if ($categoria) {
            $produtos = array_filter($produtos, function($p) use ($categoria) {
                return $p['categoria'] === $categoria;
            });
        }
        
        include __DIR__ . '/../Views/aluno/loja.php';
    }

    public function minhasCompras() {
        $this->checarPermissao();
        
        $idAluno = $_SESSION['user_id'];
        $compras = $this->compraModel->listarCompras($idAluno);
        
        include __DIR__ . '/../Views/aluno/minhas_compras.php';
    }
}
?>