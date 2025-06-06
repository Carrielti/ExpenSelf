<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = $_SESSION['id_usuario'];
    $id_receita = intval($_POST['id_receita']);
    $nome = $_POST['nome'];
    $valor = floatval($_POST['valor']);
    $data = $_POST['data'];

    $verifica = $conn->prepare("SELECT id_receita FROM receitas WHERE id_receita = ? AND id_usuario = ?");
    $verifica->bind_param("ii", $id_receita, $id_usuario);
    $verifica->execute();
    $res = $verifica->get_result();

    if ($res->num_rows === 1) {
        $update = $conn->prepare("UPDATE receitas SET nome=?, valor=?, data_receita=? WHERE id_receita=?");
        $update->bind_param("sdsi", $nome, $valor, $data, $id_receita);
        if ($update->execute()) {
            header("Location: listar_receitas.php?msg=editada");
            exit();
        } else {
            echo "Erro ao atualizar receita.";
        }
    } else {
        echo "Receita não encontrada ou não pertence ao usuário.";
    }
}
?>
