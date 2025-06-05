<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = $_SESSION['id_usuario'];
    $id_despesa = intval($_POST['id_despesa']);
    $nome = $_POST['nome'];
    $valor = floatval($_POST['valor']);

    $verifica = $conn->prepare("SELECT id_despesa FROM despesas WHERE id_despesa = ? AND id_usuario = ?");
    $verifica->bind_param("ii", $id_despesa, $id_usuario);
    $verifica->execute();
    $res = $verifica->get_result();

    if ($res->num_rows === 1) {
        $update = $conn->prepare("UPDATE despesas SET nome=?, valor=? WHERE id_despesa=?");
        $update->bind_param("sdi", $nome, $valor, $id_despesa);
        if ($update->execute()) {
            // --- Executa script Python para atualizar no Firebase ---
            $comando = escapeshellcmd("python enviar_firebase.py \"$nome\" $valor \"$id_usuario\" editar");
            exec($comando);

            header("Location: listar_despesas.php?msg=editada");
            exit();
        } else {
            echo "Erro ao atualizar.";
        }
    } else {
        echo "Despesa não encontrada ou não pertence ao usuário.";
    }
}
?>
