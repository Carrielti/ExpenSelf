<?php
include("conexao.php"); // Arquivo com conexão MySQL

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar senha

    // Verifica se o usuário já existe
    $check = $conn->prepare("SELECT id_usuario FROM usuario WHERE nome = ?");
    $check->bind_param("s", $nome);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Usuário já cadastrado
        echo "<script>alert('Usuário já cadastrado. Faça login.'); window.location.href='index.html';</script>";
    } else {
        // Cadastra novo usuário
        $id_nivel = 1; // Padrão
        $stmt = $conn->prepare("INSERT INTO usuario (nome, senha, id_nivel) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nome, $senha, $id_nivel);

        if ($stmt->execute()) {
            echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='index.html';</script>";
        } else {
            echo "Erro ao cadastrar: " . $conn->error;
        }
    }

    $check->close();
    $conn->close();
}
?>
