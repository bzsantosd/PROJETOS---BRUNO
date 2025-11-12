<?php
// Arquivo: Config/Database.php

// ----------------------------------------------------
// ⚠️ ATENÇÃO: Substitua os dados abaixo pelos seus!
// ----------------------------------------------------
$host = 'localhost'; // Seu host (geralmente localhost)
$db   = 'TechFit';   // Nome do seu banco de dados
$user = 'root';      // Seu usuário do MySQL
$pass = 'sua_senha'; // Sua senha do MySQL
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    // Define o modo de erro para exceções
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Define o modo de busca padrão para arrays associativos
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     // Cria o objeto de conexão PDO
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Em caso de erro na conexão, interrompe o script e exibe a mensagem
     die("Erro de Conexão com o Banco de Dados: " . $e->getMessage());
}

// O objeto $pdo agora está pronto para ser usado