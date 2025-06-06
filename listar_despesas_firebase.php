<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso negado. Faça login!'); window.location.href='index.html';</script>";
    exit;
}

$nome_usuario = $_SESSION['nome'];

// URL da sua API Flask no Render
$url = "https://expenself.onrender.com/listar"; // substitua pelo seu link real

$response = file_get_contents($url);
if ($response === FALSE) {
    $despesas = [];
    $erro = true;
} else {
    $despesas = json_decode($response, true);
    $erro = false;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Minhas Despesas (Firebase)</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/img/icone-logo.png" type="image/png">

  <style>
    table {
      width: 90%;
      margin: 30px auto;
      border-collapse: collapse;
      background-color: #333;
      color: #fff;
    }
    th, td {
      padding: 10px;
      border: 1px solid #555;
    }
    th {
      background-color: #2980b9;
    }
    .botoes {
      display: flex;
      justify-content: center;
      gap: 10px;
    }
  </style>
</head>

<body>
<header>
