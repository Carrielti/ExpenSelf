<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso negado. Faça login!'); window.location.href='index.html';</script>";
}

$id_usuario = $_SESSION['id_usuario'];
$nome_usuario = $_SESSION['nome'];

$sql = "SELECT id_receita, nome, valor, data_receita FROM receitas WHERE id_usuario = $id_usuario ORDER BY data_receita DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Minhas Receitas</title>
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="/img/icone-logo.png" type="image/png">
  <style>
    table {
      width: 90%;
      margin: 30px auto;
      border-collapse: collapse;
      background-color: #2c3e50;
      color: #fff;
    }
    th, td {
      padding: 10px;
      border: 1px solid #555;
    }
    th {
      background-color: #27ae60;
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
      Receita excluída com sucesso!
    </div>
  <?php elseif ($_GET['msg'] == 'editada'): ?>
    <div class="mensagem-flash" style="background-color: #2ecc71;">
      Receita editada com sucesso!
    </div>
  <?php elseif ($_GET['msg'] == 'adicionada'): ?>
    <div class="mensagem-flash" style="background-color: #2980b9;">
      Receita adicionada com sucesso!
    </div>
  <?php endif; ?>
<?php endif; ?>

<div class="container-superior">
  <h1 class="titulo-despesas">Receitas de <?php echo htmlspecialchars($nome_usuario); ?></h1>

  <div class="botoes-superiores">
    <button class="botao-adicionar" onclick="location.href='e_nova_receita.html'">Adicionar Despesa</button>
    <button on class="botao-exportar" onclick="location.href='exportar_receitas_pdf.php'">Exportar para PDF</button>
  </div>
</div>

<table>
  <tr>
    <th>Nome</th>
    <th>Valor (R$)</th>
    <th>Data</th>
    <th>Ações</th>
  </tr>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($linha = $result->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($linha['nome']) ?></td>
        <td><?= number_format($linha['valor'], 2, ',', '.') ?></td>
        <td><?= date("d/m/Y", strtotime($linha['data_receita'])) ?></td>
        <td class="botoes">
          <form action="editar_receita.php" method="GET" style="display:inline;">
            <input type="hidden" name="id_receita" value="<?= $linha['id_receita'] ?>">
            <button class="editar-btn" type="submit">Editar</button>
          </form>
          <form action="excluir_receita.php" method="POST" onsubmit="return confirm('Deseja realmente excluir esta receita?');" style="display:inline;">
            <input type="hidden" name="id_receita" value="<?= $linha['id_receita'] ?>">
            <button class="excluir-btn" type="submit">Excluir</button>
          </form>
        </td>
      </tr>
    <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="4" style="text-align:center;">Nenhuma receita cadastrada.</td></tr>
  <?php endif; ?>
</table>

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
