<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
     echo "<script>alert('Acesso negado. Faça login!'); window.location.href='index.html';</script>";
}

$id_usuario = $_SESSION['id_usuario'];
$nome_usuario = $_SESSION['nome'];

// ❌ Removido o campo data_despesa da consulta
$sql = "SELECT id_despesa, nome, valor FROM despesas WHERE id_usuario = $id_usuario";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Minhas Despesas</title>
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
  </style>
  
</head>
<body>
<header>
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
  <h1 class="titulo-despesas">Despesas de <?php echo htmlspecialchars($nome_usuario); ?></h1>

  <div class="botoes-superiores">
    <button class="botao-adicionar" onclick="location.href='e_nova_despesa.html'">Adicionar Despesa</button>
    <button class="botao-exportar" onclick="location.href='exportar_pdf.php'">Exportar para PDF</button>
  </div>
</div>

  <table>
    <tr>
      <th>Nome</th>
      <th>Valor (R$)</th>
      <th>Ações</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($linha = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($linha['nome']) ?></td>
          <td><?= number_format($linha['valor'], 2, ',', '.') ?></td>
          <td class="botoes">
            <!-- Botão Editar -->
            <form action="editar_despesa.php" method="GET" style="display:inline;">
              <input type="hidden" name="id_despesa" value="<?= $linha['id_despesa'] ?>">
              <button class="editar-btn" type="submit">Editar</button>
            </form>

            <!-- Botão Excluir -->
            <form action="excluir_despesa.php" method="POST" onsubmit="return confirm('Deseja realmente excluir esta despesa?');" style="display:inline;">
              <input type="hidden" name="id_despesa" value="<?= $linha['id_despesa'] ?>">
              <button class="excluir-btn" type="submit">Excluir</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="3" style="text-align:center;">Nenhuma despesa cadastrada.</td></tr>
    <?php endif; ?>
  </table>

  <script src="script.js"></script>

    <script>
  // Espera o DOM carregar
  window.addEventListener('DOMContentLoaded', () => {
    const mensagem = document.querySelector('.mensagem-flash');
    if (mensagem) {
      setTimeout(() => {
        mensagem.classList.add('fade-out');
        setTimeout(() => mensagem.remove(), 500); // remove do DOM após animação
      }, 3000); // 3 segundos
    }
  });
  function toggleUserMenu() {
    const dropdown = document.getElementById("userDropdown");
    dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
  }

</script>


</body>
</html>
