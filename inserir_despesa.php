<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso negado. Faça login!'); window.location.href='index.html';</script>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Verifica se todos os campos foram enviados
if (isset($_POST['nome'], $_POST['valor'], $_POST['data_despesa'])) {
    $nome = trim($_POST['nome']);
    $valor = floatval(str_replace(',', '.', $_POST['valor']));
    $data_despesa = $_POST['data_despesa']; // Esperado no formato YYYY-MM-DD

    if ($nome === '' || $valor <= 0) {
        echo "<script>alert('Preencha todos os campos corretamente.'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO despesas (id_usuario, nome, valor, data_despesa) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isds", $id_usuario, $nome, $valor, $data_despesa);

    if ($stmt->execute()) {
        header("Location: listar_despesas.php?msg=adicionada");
    } else {
        echo "<script>alert('Erro ao adicionar despesa.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Dados incompletos.'); window.history.back();</script>";
}
?>
