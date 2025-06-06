<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso negado. Faça login!'); window.location.href='index.html';</script>";
}

$nome = $_SESSION['nome']; // <- Aqui define corretamente a variável $nome
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ExpenSelf - Home</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="icon" href="/img/icone-logo.png" type="image/png">

</head>

<body>
  <div class="top-bar">
  <!-- Menu hamburguer + navegação -->
  <div class="menu-container">
    <div class="hamburguer" id="hamburguer">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>
    <nav id="nav-menu" class="nav-menu">
      <ul>
        <li><a href="e_home.php">Home</a></li><br>
          <li><a href="listar_despesas.php">Despesas</a></li><br>
          <li><a href="listar_receitas.php">Receitas</a></li><br>
          <li><a href="e_sobre.php">Sobre</a></li><br>
          <li><a href="e_contato.php">Contato</a></li><br>
      </ul>
    </nav>
  </div>

  <!-- Logo centralizada -->
  <div class="logo-container">
    <img class="logo-img" src="/img/logo.png" alt="Logo">
  </div>

  <!-- Ícone de usuário à direita -->
  <div class="user-container">
    <div class="user-circle" onclick="toggleUserMenu()" title="Ver informações">
      <img src="/img/user.png" alt="Usuário">
    </div>
    <div class="user-dropdown" id="userDropdown">
      <p><strong><?php echo htmlspecialchars($nome); ?></strong></p>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</div>

<div class="container-superior">
    <h1>Sobre o ExpenSelf</h1>
  </div>

  <div class="sobre-box">
  <h1>Sobre o ExpenSelf</h1>
  <p>
    O ExpenSelf é uma plataforma dedicada ao controle financeiro pessoal. Nosso objetivo é ajudar você a registrar suas despesas, acompanhar seus gastos e melhorar sua relação com o dinheiro.
    Com ferramentas simples e visuais, é possível registrar transações, verificar relatórios e manter sua vida financeira sob controle.
  </p>
</div>


<script src="script.js"></script>

</body>
</html>