<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

if (!isset($_GET['id_receita'])) {
    die("ID da receita não fornecido.");
}

$id_receita = intval($_GET['id_receita']);
$id_usuario = $_SESSION['id_usuario'];

$sql = $conn->prepare("SELECT * FROM receitas WHERE id_receita = ? AND id_usuario = ?");
$sql->bind_param("ii", $id_receita, $id_usuario);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows !== 1) {
    die("Receita não encontrada.");
}

$receita = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Receita</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="home">
    <div class="expense-container">
      <h1>Editar Receita</h1>
      <form action="atualizar_receita.php" method="POST">
        <input type="hidden" name="id_receita" value="<?= $receita['id_receita'] ?>">

        <label for="nome">Nome da Receita</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($receita['nome']) ?>" required>

        <label for="valor">Valor</label>
        <input type="number" id="valor" name="valor" value="<?= $receita['valor'] ?>" min="0" step="0.01" required>

        <label for="data">Data</label>
        <input type="date" id="data" name="data" value="<?= $receita['data_receita'] ?>" required>

        <button type="submit">Salvar Alterações</button>
      </form>
    </div>
  </div>
</body>
</html>
