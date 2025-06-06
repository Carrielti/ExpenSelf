<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["erro" => "Usuário não logado"]);
    exit;
}

$id = $_SESSION['id_usuario'];

$sqlReceitas = "SELECT SUM(valor) AS total FROM receitas WHERE id_usuario = $id";
$sqlDespesas = "SELECT SUM(valor) AS total FROM despesas WHERE id_usuario = $id";

$resReceitas = $conn->query($sqlReceitas)->fetch_assoc();
$resDespesas = $conn->query($sqlDespesas)->fetch_assoc();

echo json_encode([
  "receitas" => floatval($resReceitas['total'] ?? 0),
  "despesas" => floatval($resDespesas['total'] ?? 0)
]);
?>
