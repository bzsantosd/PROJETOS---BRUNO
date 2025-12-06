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
if (!isset($data['email']) || !isset($data['senha'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Email e senha são obrigatórios!'
    ]);
    exit;
}

$email = trim($data['email']);
$senha = trim($data['senha']);

// Validação de campos vazios
if (empty($email) || empty($senha)) {
    echo json_encode([
        'success' => false,
        'message' => 'Preencha todos os campos!'
    ]);
    exit;
}

try {
    // Obtém a conexão do banco
    $conn = Database::getInstance()->getConnection();
    
    // Busca o usuário pelo email
    $stmt = $conn->prepare("SELECT id, nome, email, senha, tipo FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifica se o usuário existe
    if ($result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Email ou senha incorretos!'
        ]);
        exit;
    }
    
    $user = $result->fetch_assoc();
    
    // Verifica se a senha está correta
    if (!password_verify($senha, $user['senha'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Email ou senha incorretos!'
        ]);
        exit;
    }
    
    // Login bem-sucedido! Salva os dados na sessão
    $_SESSION['user'] = [
        'id' => $user['id'],
        'nome' => $user['nome'],
        'email' => $user['email'],
        'tipo' => $user['tipo']
    ];
    
    // Log de sucesso
    error_log("✅ Login bem-sucedido: " . $user['email'] . " (Tipo: " . $user['tipo'] . ")");
    
    // Retorna sucesso
    echo json_encode([
        'success' => true,
        'message' => 'Login realizado com sucesso!',
        'user' => [
            'id' => $user['id'],
            'nome' => $user['nome'],
            'email' => $user['email'],
            'tipo' => $user['tipo']
        ]
    ]);
    
} catch (Exception $e) {
    error_log("❌ Erro no login: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao processar login. Tente novamente.'
    ]);
}
?>