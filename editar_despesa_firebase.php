<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

$nome_usuario = $_SESSION['nome'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Exibe o formulário
    if (!isset($_GET['id']) || !isset($_GET['nome']) || !isset($_GET['valor'])) {
        die("Parâmetros incompletos.");
    }

    $id = $_GET['id'];
    $nome = $_GET['nome'];
    $valor = $_GET['valor'];

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $valor = floatval($_POST['valor']);

    // Monta a requisição PUT para a API Flask
    $url = "https://expenself.onrender.com/editar/$id";

    $dados = [
        "nome" => $nome,
        "valor" => $valor,
        "usuario" => $nome_usuario
    ];

    $options = [
        "http" => [
            "method"  => "PUT",
            "header"  => "Content-Type: application/json",
            "content" => json_encode($dados)
        ]
    ];

    $context = stream_context_create($options);
    $resposta = @file_get_contents($url, false, $context);

    if ($resposta === FALSE) {
        echo "Erro ao atualizar a despesa.";
    } else {
        header("Location: listar_despesas_firebase.php?msg=editada");
        exit;
    }
}
?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
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
      <form action="editar_despesa_firebase.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

        <label for="nome">Nome da Despesa</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required>

        <label for="valor">Valor</label>
        <input type="number" id="valor" name="valor" value="<?= htmlspecialchars($valor) ?>" min="0" step="0.01" required>

        <button type="submit">Salvar Alterações</button>
      </form>
    </div>
  </div>
</body>
</html>
<?php endif; ?>
