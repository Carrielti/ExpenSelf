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
    <h1>Entre em Contato</h1>
  </div>

  <section class="content-section" style="padding: 40px; max-width: 800px; margin: auto; color: white;">
  <h2>Fale Conosco</h2>

  <div style="
    background-color: #222;  /* Fundo escuro para combinar com seu tema */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.4);
  ">
    <form action="#" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
      
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" placeholder="exemplo@email.com" required>

      <label for="assunto">Assunto:</label>
      <input type="text" id="assunto" name="assunto" placeholder="Sobre o que deseja falar?" required>

      <label for="mensagem">Mensagem:</label>
      <textarea id="mensagem" name="mensagem" rows="5" placeholder="Digite sua mensagem aqui..." required></textarea>

      <button type="submit" style="
        padding: 12px;
        background-color: #2980b9;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        font-size: 1em;
      ">Enviar Mensagem</button>

    </form>
  </div>
</section>



<script src="script.js"></script>

</body>
</html>