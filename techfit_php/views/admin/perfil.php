<?php
session_start();
// Verifique se o usuário está logado, se não, redirecione para o login
if (!isset($_SESSION['nome_usuario'])) {
    header('Location: /techfit_php/public/login.html');
    exit();
}

$nome_completo = $_SESSION['nome_completo']; // Exemplo: Pego da sessão
$data_nascimento = '02/08/2005'; // Exemplo: Pego do BD ou da sessão
$membro_desde = '2020'; // Exemplo: Pego do BD ou da sessão
$plano = 'AVANÇADO'; // Exemplo: Pego do BD ou da sessão
$foto_url = $_SESSION['foto_perfil_url']; // Exemplo: Pego da sessão ou do BD
?>

<!DOCTYPE html>
<html lang="pt-BR">
<body>
  <header class="header">
    <div class="user-info">
        <div class="user-avatar" style="background-image: url('<?php echo $foto_url; ?>');"></div>
        <span><?php echo $nome_completo; ?></span>
    </div>
</header>
<div class="header-line-separator"></div>
    <main class="container">

        <section class="profile-details">
            <p><strong>Nome completo: </strong><?php echo $nome_completo; ?></p>
            <p><strong>Data Nascimento: </strong><?php echo $data_nascimento; ?></p>
            <p><strong>Membro desde: </strong><?php echo $membro_desde; ?></p>
            <p><strong>Plano: </strong><?php echo $plano; ?></p>
        </section>
        </main>
    </html>