<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso negado. Faça login!'); window.location.href='index.html';</script>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$nome_usuario = $_SESSION['nome'];

// Chamada para a API Python no Render (Firebase)
$url = "https://expenself.onrender.com/listar"; // Substitua com seu endpoint real

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
    .excluir-btn {
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 4px;
      cursor: pointer;
    }
    .editar-btn {
      background-color: #f1c40f;
      color: black;
      border: none;
      padding: 6px 10px;
      border-radius: 4px;
      cursor: pointer;
    }
    .mensagem-flash {
      width: 90%;
      margin: 20px auto;
      padding: 12px;
      color: #fff;
      border-radius: 4px;
      text-align: center;
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

<?php if (isset($_GET['msg'])): ?>
  <?php if ($_GET['msg'] == 'excluida'): ?>
    <div class="mensagem-flash" style="background-color: #e74c3c;">
      Despesa excluída com sucesso!
    </div>
  <?php elseif ($_GET['msg'] == 'editada'): ?>
    <div class="mensagem-flash" style="background-color: #2ecc71;">
      Despesa editada com sucesso!
    </div>
  <?php elseif ($_GET['msg'] == 'adicionada'): ?>
    <div class="mensagem-flash" style="background-color:rgb(46, 64, 204);">
      Despesa adicionada com sucesso!
    </div>
  <?php endif; ?>
<?php endif; ?>

<div class="container-superior">
  <h1 class="titulo-despesas">Despesas (Firebase) de <?php echo htmlspecialchars($nome_usuario); ?></h1>
  <div class="botoes-superiores">
    <button class="botao-adicionar" onclick="location.href='e_nova_despesa.html'">Adicionar Despesa</button>
    <button class="botao-exportar" onclick="location.href='exportar_pdf.php'">Exportar para PDF</button>
  </div>
</div>

<?php if ($erro): ?>
  <p style="text-align:center; color:red;">Erro ao buscar dados: <?= htmlspecialchars($erro_msg) ?></p>
<?php else: ?>
  <table>
    <tr>
      <th>Nome</th>
      <th>Valor (R$)</th>
      <th>Usuário</th>
      <th>Ações</th>
    </tr>
    <?php if (!empty($despesas)): ?>
      <?php foreach ($despesas as $linha): ?>
        <tr>
          <td><?= htmlspecialchars($linha['nome']) ?></td>
          <td><?= number_format($linha['valor'], 2, ',', '.') ?></td>
          <td><?= htmlspecialchars($linha['usuario']) ?></td>
          <td class="botoes">
            <!-- Simulação de editar/excluir via ID Firebase -->
            <form action="editar_despesa_firebase.php" method="GET" style="display:inline;">
            <input type="hidden" name="id" value="<?= $linha['id'] ?>">
            <input type="hidden" name="nome" value="<?= htmlspecialchars($linha['nome']) ?>">
            <input type="hidden" name="valor" value="<?= htmlspecialchars($linha['valor']) ?>">
            <button class="editar-btn" type="submit">Editar</button>
            </form>


            <form action="excluir_despesa_firebase.php" method="POST" onsubmit="return confirm('Deseja realmente excluir esta despesa?');" style="display:inline;">
              <input type="hidden" name="id" value="<?= $linha['id'] ?>">
              <button class="excluir-btn" type="submit">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="4" style="text-align:center;">Nenhuma despesa cadastrada no Firebase.</td></tr>
    <?php endif; ?>
  </table>
<?php endif; ?>

<script src="script.js"></script>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    const mensagem = document.querySelector('.mensagem-flash');
    if (mensagem) {
      setTimeout(() => {
        mensagem.classList.add('fade-out');
        setTimeout(() => mensagem.remove(), 500);
      }, 3000);
    }
  });
  function toggleUserMenu() {
    const dropdown = document.getElementById("userDropdown");
    dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
  }
</script>
</body>
</html>
