<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT nome, SUM(valor) as total FROM despesas WHERE id_usuario = ? GROUP BY nome";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$dados = [];
while ($row = $result->fetch_assoc()) {
    $dados[] = [
        'nome' => $row['nome'],
        'total' => floatval($row['total'])
    ];
}

header('Content-Type: application/json');
echo json_encode($dados);
?>
