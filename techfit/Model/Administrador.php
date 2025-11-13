<?php
// Model/Administrador.php

class Administrador {
    private $pdo;
    private $table = 'Administrador';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Busca administrador por email
     */
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Login de administrador
     * Nota: Como sua tabela não tem senha, vamos usar email fixo
     */
    public function login($email, $senha) {
        // Admin fixo do seu sistema
        $adminEmail = 'adm@techfit.com';
        $adminSenha = 'TechF!tAdm#2025$';

        if ($email === $adminEmail && $senha === $adminSenha) {
            // Busca ou cria admin no banco
            $admin = $this->buscarPorEmail($adminEmail);
            
            if (!$admin) {
                // Cria admin se não existir
                $sql = "INSERT INTO {$this->table} (nome_administrador, carga_horaria, salario, email) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['Administrador Master', 40, 5000.00, $adminEmail]);
                $admin = $this->buscarPorEmail($adminEmail);
            }

            return [
                'sucesso' => true,
                'admin' => [
                    'id' => $admin['Id_Administrador'],
                    'nome' => $admin['nome_administrador'],
                    'email' => $admin['email']
                ]
            ];
        }

        return ['sucesso' => false, 'mensagem' => 'Credenciais inválidas!'];
    }

    /**
     * Lista todos os administradores
     */
    public function listarTodos() {
        $sql = "SELECT * FROM {$this->table} ORDER BY nome_administrador";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Cadastra novo administrador
     */
    public function cadastrar($nome, $cargaHoraria, $salario, $email) {
        $sql = "INSERT INTO {$this->table} (nome_administrador, carga_horaria, salario, email) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        try {
            $resultado = $stmt->execute([$nome, $cargaHoraria, $salario, $email]);
            return [
                'sucesso' => $resultado,
                'id' => $this->pdo->lastInsertId(),
                'mensagem' => 'Administrador cadastrado!'
            ];
        } catch (PDOException $e) {
            return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar: ' . $e->getMessage()];
        }
    }
}
?>