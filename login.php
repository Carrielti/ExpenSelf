<?php
session_start();
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $senha = $_POST['senha'];

    // Verifica se o usuário existe
    $stmt = $conn->prepare("SELECT id_usuario, nome, senha FROM usuario WHERE nome = ?");
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Verifica se a senha digitada confere com a senha criptografada
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome'] = $usuario['nome'];

            echo "<script>alert('Login realizado com sucesso!'); window.location.href='e_home.php';</script>";
        } else {
            echo "<script>alert('Senha incorreta.'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado.'); window.location.href='index.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
