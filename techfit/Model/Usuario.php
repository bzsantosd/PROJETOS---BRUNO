<?php
// Model/Usuario.php

class Usuario {
    private $pdo;
    private $table = 'Usuarios';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Busca usuário por email
     */
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Busca usuário por ID
     */
    public function buscarPorId($id) {
        $sql = "SELECT * FROM {$this->table} WHERE Id_Usuario = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Login de usuário (usando email e senha)
     */
    public function login($email, $senha) {
        $usuario = $this->buscarPorEmail($email);
        
        if (!$usuario) {
            return ['sucesso' => false, 'mensagem' => 'Usuário não encontrado!'];
        }

        // Verifica a senha (assumindo que está em hash)
        if (password_verify($senha, $usuario['senha'])) {
            return [
                'sucesso' => true,
                'usuario' => [
                    'id' => $usuario['Id_Usuario'],
                    'nome' => $usuario['nome'],
                    'email' => $usuario['email'],
                    'tipo' => $usuario['tipo']
                ]
            ];
        }

        return ['sucesso' => false, 'mensagem' => 'Senha incorreta!'];
    }

    /**
     * Cadastra novo usuário
     */
    public function cadastrar($nome, $email, $senha, $tipo = 'aluno') {
        // Verifica se email já existe
        if ($this->buscarPorEmail($email)) {
            return ['sucesso' => false, 'mensagem' => 'Email já cadastrado!'];
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO {$this->table} (nome, email, senha, tipo) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        try {
            $resultado = $stmt->execute([$nome, $email, $senhaHash, $tipo]);
            return [
                'sucesso' => $resultado,
                'id' => $this->pdo->lastInsertId(),
                'mensagem' => 'Usuário cadastrado com sucesso!'
            ];
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar usuário: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar usuário.'];
        }
    }

    /**
     * Atualiza dados do usuário
     */
    public function atualizar($id, $nome, $email) {
        $sql = "UPDATE {$this->table} 
                SET nome = ?, email = ?
                WHERE Id_Usuario = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        try {
            $resultado = $stmt->execute([$nome, $email, $id]);
            return ['sucesso' => $resultado, 'mensagem' => 'Dados atualizados!'];
        } catch (PDOException $e) {
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar.'];
        }
    }

    /**
     * Atualiza senha do usuário
     */
    public function atualizarSenha($id, $senhaAntiga, $senhaNova) {
        $usuario = $this->buscarPorId($id);
        
        if (!$usuario) {
            return ['sucesso' => false, 'mensagem' => 'Usuário não encontrado!'];
        }

        if (!password_verify($senhaAntiga, $usuario['senha'])) {
            return ['sucesso' => false, 'mensagem' => 'Senha antiga incorreta!'];
        }

        $senhaHash = password_hash($senhaNova, PASSWORD_DEFAULT);
        
        $sql = "UPDATE {$this->table} SET senha = ? WHERE Id_Usuario = ?";
        $stmt = $this->pdo->prepare($sql);
        
        try {
            $resultado = $stmt->execute([$senhaHash, $id]);
            return ['sucesso' => $resultado, 'mensagem' => 'Senha atualizada!'];
        } catch (PDOException $e) {
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar senha.'];
        }
    }

    /**
     * Remove usuário
     */
    public function remover($id) {
        $sql = "DELETE FROM {$this->table} WHERE Id_Usuario = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Lista todos os usuários
     */
    public function listarTodos($tipo = null) {
        if ($tipo) {
            $sql = "SELECT * FROM {$this->table} WHERE tipo = ? ORDER BY nome";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$tipo]);
        } else {
            $sql = "SELECT * FROM {$this->table} ORDER BY nome";
            $stmt = $this->pdo->query($sql);
        }
        
        return $stmt->fetchAll();
    }

    /**
     * Conta usuários por tipo
     */
    public function contarPorTipo($tipo) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE tipo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tipo]);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
?>