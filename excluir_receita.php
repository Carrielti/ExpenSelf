<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_receita'])) {
    $id_receita = intval($_POST['id_receita']);
    $id_usuario = $_SESSION['id_usuario'];

    $consulta = $conn->prepare("SELECT nome FROM receitas WHERE id_receita = ? AND id_usuario = ?");
    $consulta->bind_param("ii", $id_receita, $id_usuario);
    $consulta->execute();
    $res = $consulta->get_result();

    if ($res->num_rows === 1) {
        $deleta = $conn->prepare("DELETE FROM receitas WHERE id_receita = ?");
        $deleta->bind_param("i", $id_receita);

        if ($deleta->execute()) {
            header("Location: listar_receitas.php?msg=excluida");
            exit();
        } else {
            echo "Erro ao excluir receita.";
        }
    } else {
        echo "Receita não encontrada ou não pertence ao usuário.";
    }
} else {
    echo "Requisição inválida.";
}
?>
