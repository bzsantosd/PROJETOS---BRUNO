<?php
// Model/Aluno.php

class Aluno {
    private $pdo;
    private $table = 'Aluno';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Busca aluno por email
     */
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Busca aluno por CPF
     */
    public function buscarPorCpf($cpf) {
        $sql = "SELECT * FROM {$this->table} WHERE cpf = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$cpf]);
        return $stmt->fetch();
    }

    /**
     * Busca aluno por email e CPF (recuperação de senha)
     */
    public function buscarPorEmailCpf($email, $cpf) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? AND cpf = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email, $cpf]);
        return $stmt->fetch();
    }

    /**
     * Cadastra novo aluno
     * Nota: Como sua tabela não tem senha, vamos simular com email como identificador
     */
    public function cadastrar($nome, $email, $cpf, $endereco, $contato, $idAdministrador = 1) {
        // Verifica se email já existe
        if ($this->buscarPorEmail($email)) {
            return ['sucesso' => false, 'mensagem' => 'Email já cadastrado!'];
        }

        // Verifica se CPF já existe
        if ($this->buscarPorCpf($cpf)) {
            return ['sucesso' => false, 'mensagem' => 'CPF já cadastrado!'];
        }

        $sql = "INSERT INTO {$this->table} (nome_aluno, email, cpf, endereco, contato, Id_Administrador) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        try {
            $resultado = $stmt->execute([$nome, $email, $cpf, $endereco, $contato, $idAdministrador]);
            return [
                'sucesso' => $resultado,
                'id' => $this->pdo->lastInsertId(),
                'mensagem' => 'Cadastro realizado com sucesso!'
            ];
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar aluno: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar.'];
        }
    }

    /**
     * Login de aluno (simulado com email)
     * Como não há senha na tabela, vamos usar email + CPF como validação
     */
    public function login($email, $cpf) {
        $aluno = $this->buscarPorEmailCpf($email, $cpf);
        
        if (!$aluno) {
            return ['sucesso' => false, 'mensagem' => 'Dados não encontrados!'];
        }

        return [
            'sucesso' => true,
            'aluno' => [
                'id' => $aluno['Id_Aluno'],
                'nome' => $aluno['nome_aluno'],
                'email' => $aluno['email'],
                'cpf' => $aluno['cpf']
            ]
        ];
    }

    /**
     * Lista todos os alunos
     */
    public function listarTodos() {
        $sql = "SELECT a.*, ad.nome_administrador 
                FROM {$this->table} a
                LEFT JOIN Administrador ad ON a.Id_Administrador = ad.Id_Administrador
                ORDER BY a.nome_aluno";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Busca aluno por ID
     */
    public function buscarPorId($id) {
        $sql = "SELECT a.*, ad.nome_administrador 
                FROM {$this->table} a
                LEFT JOIN Administrador ad ON a.Id_Administrador = ad.Id_Administrador
                WHERE a.Id_Aluno = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Atualiza dados do aluno
     */
    public function atualizar($id, $nome, $email, $endereco, $contato) {
        $sql = "UPDATE {$this->table} 
                SET nome_aluno = ?, email = ?, endereco = ?, contato = ?
                WHERE Id_Aluno = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        try {
            $resultado = $stmt->execute([$nome, $email, $endereco, $contato, $id]);
            return ['sucesso' => $resultado, 'mensagem' => 'Dados atualizados!'];
        } catch (PDOException $e) {
            return ['sucesso' => false, 'mensagem' => 'Erro ao atualizar.'];
        }
    }

    /**
     * Remove aluno
     */
    public function remover($id) {
        $sql = "DELETE FROM {$this->table} WHERE Id_Aluno = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>