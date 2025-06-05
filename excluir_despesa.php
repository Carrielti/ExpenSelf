<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_despesa'])) {
    $id_despesa = intval($_POST['id_despesa']);
    $id_usuario = $_SESSION['id_usuario'];

    $consulta = $conn->prepare("SELECT nome, valor FROM despesas WHERE id_despesa = ? AND id_usuario = ?");
    $consulta->bind_param("ii", $id_despesa, $id_usuario);
    $consulta->execute();
    $res = $consulta->get_result();

    if ($res->num_rows === 1) {
        $dados = $res->fetch_assoc();
        $nome = $dados['nome'];
        $valor = $dados['valor'];

        $deleta = $conn->prepare("DELETE FROM despesas WHERE id_despesa = ?");
        $deleta->bind_param("i", $id_despesa);
        if ($deleta->execute()) {
            // --- Executa script Python para deletar do Firebase ---
            $comando = escapeshellcmd("python enviar_firebase.py \"$nome\" $valor \"$id_usuario\" excluir");
            exec($comando);

            header("Location: listar_despesas.php?msg=excluida");
            exit();
        } else {
            echo "Erro ao excluir.";
        }
    } else {
        echo "Despesa não encontrada ou não pertence ao usuário.";
    }
} else {
    echo "Requisição inválida.";
}
?>
