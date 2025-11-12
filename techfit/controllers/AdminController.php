<?php
// Controller/AdminController.php

class AdminController {
    private $produtoModel;

    // Recebe a conexão PDO via Injeção de Dependência
    public function __construct(PDO $pdo) {
        $this->produtoModel = new Produto($pdo);
    }
    
    // Método para checar se o usuário é Admin (essencial!)
    private function checarPermissao() {
        session_start();
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }
    }

    // Ação para exibir e processar o cadastro de produtos
    public function cadastroProdutos() {
        $this->checarPermissao(); // 1. Checa a permissão de ADM

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Requisição POST: Processa o formulário

            // 2. Coleta e sanitiza os dados
            $nome = htmlspecialchars($_POST['nome_produto']);
            $preco = (float) $_POST['preco'];
            $categoria = htmlspecialchars($_POST['categoria']);
            $quantidade = (int) $_POST['quantidade'];
            
            // Exemplo: ID do administrador logado (vem da sessão)
            $id_administrador = $_SESSION['user_id'] ?? 1; 

            // 3. O Controller chama o MODEL para fazer a inserção no DB
            $sucesso = $this->produtoModel->cadastrarProduto(
                $nome, 
                $preco, 
                $categoria, 
                $quantidade, 
                $id_administrador
            );

            if ($sucesso) {
                // 4. Se o Model for bem-sucedido, redireciona (PRG Pattern)
                header('Location: /admin/produtos?status=sucesso');
                exit();
            } else {
                // 5. Se falhar, exibe a View novamente com uma mensagem de erro
                $erro = "Erro ao cadastrar o produto no banco de dados.";
                include('View/admin/cadastro_produtos.php');
            }

        } else {
            // Requisição GET: Apenas exibe a View do formulário
            include('View/admin/cadastro_produtos.php');
        }
    }
}
?>