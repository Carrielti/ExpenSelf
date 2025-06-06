<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['id_usuario'])) {
    die("Você precisa estar logado para inserir despesas.");
}

$nome = $_POST['nome'];
$valor = $_POST['valor'];
$id_usuario = $_SESSION['id_usuario'];

// Inserção no MySQL
$sql = "INSERT INTO despesas (nome, valor, id_usuario) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdi", $nome, $valor, $id_usuario);

if ($stmt->execute()) {
    header("Location: listar_despesas.php?msg=adicionada");
    exit();
} else {
    echo "Erro ao inserir despesa no MySQL: " . $stmt->error;
}

$conn->close();
?>
