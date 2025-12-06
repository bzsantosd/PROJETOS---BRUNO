<?php
// Inicia a sessão
session_start();

// Destrói todas as variáveis de sessão
$_SESSION = array();

// Destrói a sessão
session_destroy();

// Destrói o cookie de sessão
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Log de logout
error_log("ℹ️ Usuário deslogado");

// Redireciona para a página de login
header('Location: /login.html?logout=success');
exit;
?>