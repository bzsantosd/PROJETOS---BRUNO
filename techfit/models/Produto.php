
<?php 

class Produto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function cadastrarProduto(
        $nome, 
        $preco, 
        $categoria, 
        $quantidade, 
        $id_administrador, 
        $id_estoque = 1 
    ) {
        // 1. SQL (Prepared Statement)
        $sql = "INSERT INTO Produtos 
                (nome_produto, preco, categoria, quantidade, Id_Administrador, Id_Estoque) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        // 2. Executa a query
        $stmt = $this->pdo->prepare($sql);
        
        // 3. Retorna o resultado da execução
        return $stmt->execute([$nome, $preco, $categoria, $quantidade, $id_administrador, $id_estoque]);
    }
}
?>