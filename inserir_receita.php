<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $nome = $_POST['nome'];
    $valor = floatval($_POST['valor']);
    $data = $_POST['data'];

    $sql = "INSERT INTO receitas (nome, valor, data_receita, id_usuario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsi", $nome, $valor, $data, $id_usuario);

    if ($stmt->execute()) {
        header("Location: listar_receitas.php?msg=adicionada");
        exit();
    } else {
        echo "Erro ao inserir receita.";
    }
}
?>
