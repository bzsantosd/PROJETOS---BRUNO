<?php

class Administrador {
    private $pdo;
    private $table = 'Administrador';

    private $id;
    private $nome;
    private $cargaHoraria;
    private $salario;
    private $email;

    public function __construct($pdo, $nome = null, $cargaHoraria = null, $salario = null, $email = null) {
        $this->pdo = $pdo;
        $this->nome = $nome;
        $this->cargaHoraria = $cargaHoraria;
        $this->salario = $salario;
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function getCargaHoraria() {
        return $this->cargaHoraria;
    }
    public function setCargaHoraria($cargaHoraria) {
        $this->cargaHoraria = $cargaHoraria;
        return $this;
    }

    public function getSalario() {
        return $this->salario;
    }
    public function setSalario($salario) {
        $this->salario = $salario;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
    public function fromRow(array $row) {
        $this->id = $row['Id_Administrador'] ?? $row['id'] ?? null;
        $this->nome = $row['nome_administrador'] ?? $row['nome'] ?? null;
        $this->cargaHoraria = $row['carga_horaria'] ?? $row['cargaHoraria'] ?? null;
        $this->salario = $row['salario'] ?? $row['valor'] ?? null;
        $this->email = $row['email'] ?? null;
        return $this;
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ? $row : false;
    }

    public function login($email, $senha) {
        $adminEmail = 'adm@techfit.com';
        $adminSenha = 'TechFadm2025#';

        if ($email === $adminEmail && $senha === $adminSenha) {
            $adminRow = $this->buscarPorEmail($adminEmail);
            
            if (!$adminRow) {
                $sql = "INSERT INTO {$this->table} (nome_administrador, carga_horaria, salario, email) 
                        VALUES (?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['Administrador Master', 40, 5000.00, $adminEmail]);
                $adminRow = $this->buscarPorEmail($adminEmail);
            }

            $adminObj = (new self($this->pdo))->fromRow($adminRow);

            return [
                'sucesso' => true,
                'admin' => [
                    'id' => $adminObj->getId(),
                    'nome' => $adminObj->getNome(),
                    'email' => $adminObj->getEmail()
                ]
            ];
        }

        return ['sucesso' => false, 'mensagem' => 'Credenciais inválidas!'];
    }

    public function listarTodos() {
        $sql = "SELECT * FROM {$this->table} ORDER BY nome_administrador";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll();
        $result = [];
        foreach ($rows as $row) {
            $result[] = (new self($this->pdo))->fromRow($row);
        }
        return $result;
    }


    public function cadastrar($nome = null, $cargaHoraria = null, $salario = null, $email = null) {
        $nome = $nome ?? $this->nome;
        $cargaHoraria = $cargaHoraria ?? $this->cargaHoraria;
        $salario = $salario ?? $this->salario;
        $email = $email ?? $this->email;

        $sql = "INSERT INTO {$this->table} (nome_administrador, carga_horaria, salario, email) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        try {
            $resultado = $stmt->execute([$nome, $cargaHoraria, $salario, $email]);
            $this->id = $this->pdo->lastInsertId();
            $this->nome = $nome;
            $this->cargaHoraria = $cargaHoraria;
            $this->salario = $salario;
            $this->email = $email;

            return [
                'sucesso' => $resultado,
                'id' => $this->id,
                'mensagem' => 'Administrador cadastrado!'
            ];
        } catch (\PDOException $e) {
            return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar: ' . $e->getMessage()];
        }
    }
}
?>
