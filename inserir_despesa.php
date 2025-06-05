<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['id_usuario'])) {
    die("Você precisa estar logado para inserir despesas.");
}

$nome = $_POST['nome'];
$valor = $_POST['valor'];
$id_usuario = $_SESSION['id_usuario'];

$sql = "INSERT INTO despesas (nome, valor, id_usuario) 
        VALUES ('$nome', '$valor', '$id_usuario')";

if ($conn->query($sql) === TRUE) {
    // --- Executa script Python para enviar ao Firebase ---
    $comando = escapeshellcmd("python enviar_firebase.py \"$nome\" $valor \"$id_usuario\" adicionar");
    exec($comando);

    header("Location: listar_despesas.php?msg=adicionada");
    exit();
} else {
    echo "Erro ao inserir despesa: " . $conn->error;
}

$conn->close();
?>
