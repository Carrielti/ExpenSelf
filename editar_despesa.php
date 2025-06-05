<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

if (!isset($_GET['id_despesa'])) {
    die("ID da despesa não fornecido.");
}

$id_despesa = intval($_GET['id_despesa']);
$id_usuario = $_SESSION['id_usuario'];

// Consulta segura para obter a despesa do usuário logado
$sql = $conn->prepare("SELECT * FROM despesas WHERE id_despesa = ? AND id_usuario = ?");
$sql->bind_param("ii", $id_despesa, $id_usuario);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows !== 1) {
    die("Despesa não encontrada.");
}

$despesa = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Despesa</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="home">
    <div class="expense-container">
      <h1>Editar Despesa</h1>
      <form action="atualizar_despesa.php" method="POST">
        <input type="hidden" name="id_despesa" value="<?= $despesa['id_despesa'] ?>">

        <label for="nome">Nome da Despesa</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($despesa['nome']) ?>" required>

        <label for="valor">Valor</label>
        <input type="number" id="valor" name="valor" value="<?= $despesa['valor'] ?>" min="0" step="0.01" required>

        <button type="submit">Salvar Alterações</button>
      </form>
    </div>
  </div>
</body>
</html>
