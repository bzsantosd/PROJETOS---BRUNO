<?php
// Inicia a sessão
session_start();

// Define o cabeçalho para JSON
header('Content-Type: application/json');

// Permite CORS (se necessário)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Inclui a conexão com o banco
require_once __DIR__ . '/../core/db.php';

// Lê o JSON enviado pelo frontend
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validação básica
if (!isset($data['nome']) || !isset($data['email']) || !isset($data['senha']) || !isset($data['repita-senha'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Todos os campos são obrigatórios!'
    ]);
    exit;
}

$nome = trim($data['nome']);
$cpf = trim($data['cpf'] ?? '');
$email = trim($data['email']);
$senha = trim($data['senha']);
$repitaSenha = trim($data['repita-senha']);

// Validações
if (empty($nome) || empty($email) || empty($senha)) {
    echo json_encode([
        'success' => false,
        'message' => 'Preencha todos os campos obrigatórios!'
    ]);
    exit;
}

if ($senha !== $repitaSenha) {
    echo json_encode([
        'success' => false,
        'message' => 'As senhas não coincidem!'
    ]);
    exit;
}

if (strlen($senha) < 6) {
    echo json_encode([
        'success' => false,
        'message' => 'A senha deve ter no mínimo 6 caracteres!'
    ]);
    exit;
}

// Validação de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Email inválido!'
    ]);
    exit;
}

try {
    // Obtém a conexão do banco
    $conn = Database::getInstance()->getConnection();
    
    // Verifica se o email já existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Este email já está cadastrado!'
        ]);
        exit;
    }
    
    // Verifica se o CPF já existe (se fornecido)
    if (!empty($cpf)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE cpf = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Este CPF já está cadastrado!'
            ]);
            exit;
        }
    }
    
    // Cria o hash da senha
    $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
    
    // Insere o novo usuário
    $stmt = $conn->prepare("INSERT INTO users (nome, cpf, email, senha, tipo) VALUES (?, ?, ?, ?, 'cliente')");
    $stmt->bind_param("ssss", $nome, $cpf, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        $userId = $conn->insert_id;
        
        // Log de sucesso
        error_log("✅ Usuário cadastrado com sucesso! ID: " . $userId . " - Email: " . $email);
        
        // Retorna sucesso
        echo json_encode([
            'success' => true,
            'message' => 'Cadastro realizado com sucesso!',
            'user' => [
                'id' => $userId,
                'nome' => $nome,
                'email' => $email
            ]
        ]);
    } else {
        throw new Exception("Erro ao executar INSERT: " . $stmt->error);
    }
    
} catch (Exception $e) {
    error_log("❌ Erro no cadastro: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao processar cadastro. Tente novamente.'
    ]);
}
?>