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

<footer style="background-color: #f8f9fa; padding: 30px 20px; text-align: center; margin-top: 40px; border-top: 1px solid #ddd;">
  <div style="max-width: 900px; margin: 0 auto;">
    <img src="/img/icone-logo.png" alt="ExpenSelf Logo" style="height: 40px; margin-bottom: 10px;" />
    <h4 style="margin-bottom: 10px; color: #333;">ExpenSelf - Controle Financeiro Pessoal</h4>
    <p style="margin: 10px 0; color: #666;">Organize suas finanças, visualize seus gastos e tome decisões inteligentes!</p>

    <div style="margin-top: 20px;">
      <a href="https://api.whatsapp.com/send?phone=5515991592555" target="_blank" style="margin: 0 10px;">
        <img src="/img/icone-whatsaap.png" alt="WhatsApp" height="24">
      </a>
      <a href="https://www.instagram.com/carriel_ti/" target="_blank" style="margin: 0 10px;">
        <img src="/img/icone-instagram.png" alt="Instagram" height="24">
      </a>
      <a href="https://github.com/Carrielti" target="_blank" style="margin: 0 10px;">
        <img src="/img/icone-github.png" alt="GitHub" height="24">
      </a>
    </div>

    <p style="margin-top: 20px; font-size: 14px; color: #999;">&copy; <?php echo date('Y'); ?> ExpenSelf. Todos os direitos reservados.</p>
  </div>
</footer>

</body>
</html>