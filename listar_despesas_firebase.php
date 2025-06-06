<?php
// ✅ 1. Mostrar erros no navegador (modo debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso negado. Faça login!'); window.location.href='index.html';</script>";
    exit;
}

$nome_usuario = $_SESSION['nome'];

// ✅ 2. Testar conexão com a API Flask no Render
$url = "https://expenself.onrender.com/listar";
$response = @file_get_contents($url);

if ($response === FALSE) {
    $despesas = [];
    $erro = true;
    $erro_msg = error_get_last()['message'] ?? 'Erro desconhecido.';
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
  <div class="top-bar">
    <div class="menu-container">
      <div class="hamburguer" id="hamburguer">
        <div class="bar"></div><div class="bar"></div><div class="bar"></div>
      </div>
      <nav id="nav-menu" class="nav-menu">
        <ul>
          <li><a href="e_home.php">Home</a></li><br>
          <li><a href="listar_despesas.php">Despesas (MySQL)</a></li><br>
          <li><a href="listar_despesas_firebase.php">Despesas (Firebase)</a></li><br>
          <li><a href="e_sobre.php">Sobre</a></li><br>
          <li><a href="e_contato.php">Contato</a></li><br>
        </ul>
      </nav>
    </div>

    <div class="logo-container">
      <img class="logo-img" src="/img/logo.png" alt="Logo">
    </div>

    <div class="user-container">
      <div class="user-circle" onclick="toggleUserMenu()" title="Ver informações">
        <img src="/img/user.png" alt="Usuário">
      </div>
      <div class="user-dropdown" id="userDropdown">
        <p><strong><?php echo htmlspecialchars($nome_usuario); ?></strong></p>
        <a href="logout.php">Logout</a>
      </div>
    </div>
  </div>
</header>

<div class="container-superior">
  <h1 class="titulo-despesas">Despesas (Firebase) de <?php echo htmlspecialchars($nome_usuario); ?></h1>

  <div class="botoes-superiores">
    <button class="botao-adicionar" onclick="location.href='e_nova_despesa.html'">Adicionar Despesa</button>
  </div>
</div>

<?php if ($erro): ?>
  <p style="text-align:center; color:red;">Erro ao buscar dados da API Flask: <?= htmlspecialchars($erro_msg) ?></p>
<?php else: ?>
  <table>
    <tr>
      <th>Nome</th>
      <th>Valor (R$)</th>
      <th>Usuário</th>
    </tr>

    <?php if (!empty($despesas)): ?>
      <?php foreach ($despesas as $linha): ?>
        <tr>
          <td><?= htmlspecialchars($linha['nome']) ?></td>
          <td><?= number_format($linha['valor'], 2, ',', '.') ?></td>
          <td><?= htmlspecialchars($linha['usuario']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="3" style="text-align:center;">Nenhuma despesa cadastrada no Firebase.</td></tr>
    <?php endif; ?>
  </table>
<?php endif; ?>

<script>
  function toggleUserMenu() {
    const dropdown = document.getElementById("userDropdown");
    dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
  }
</script>

</body>
</html>
