<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymSystem - Sua Academia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="\techfit_php\public\css\inicial.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: none; }
    </style>
</head>
<header class="header-content">
  
  <nav class="navbar">
   <ul class="nav-list">
    <li class="nav-item active"><a href="/techfit_php/public/tela inicial.html" data-page="home">HOME</a></li>
    <li class="nav-item"><a href="/techfit_php/public/Planos.html" data-page="planos">PLANOS</a></li>
    <li class="nav-item"><a href="/techfit_php/public/Produtos.html" data-page="produtos">PRODUTOS</a></li>
    <li class="nav-item"><a href="/techfit_php/public/contato.html" data-page="contato">CONTATO</a></li>
    <li class="nav-item"><a href="/techfit_php/public/sobrenos.html" data-page="sobre">SOBRE NÓS</a></li>
   </ul>
  </nav>
  <div class="auth-buttons">
   <a href="login.html" class="btn btn-login">ENTRAR</a>
  </div>
 </header>


<div class="container my-5 flex-grow-1"></div>