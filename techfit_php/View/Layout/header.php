<?php
// Inicia sessão para verificar login futuramente
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymSystem - Sua Academia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="../home/index.php">
        <i class="bi bi-activity"></i> GymSystem
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="../home/index.php">Início</a></li>
        <li class="nav-item"><a class="nav-link" href="../treino/lista.php">Meus Treinos</a></li>
        <li class="nav-item"><a class="nav-link" href="../aula/reservar.php">Aulas</a></li>
      </ul>
      <div class="d-flex">
          <a href="../usuario/usuario.php" class="btn btn-outline-light me-2 btn-sm">Criar Conta</a>
          <a href="../usuario/login.php" class="btn btn-primary btn-sm">Entrar</a>
      </div>
    </div>
  </div>
</nav>

<div class="container my-5 flex-grow-1"></div>