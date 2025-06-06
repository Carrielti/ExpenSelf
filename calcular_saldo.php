<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    http_response_code(403);
    echo json_encode(["erro" => "Não autenticado"]);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Soma das receitas
$sql_receitas = "SELECT SUM(valor) as total FROM receitas WHERE id_usuario = ?";
$stmt1 = $conn->prepare($sql_receitas);
$stmt1->bind_param("i", $id_usuario);
$stmt1->execute();
$res1 = $stmt1->get_result()->fetch_assoc();
$receitas = floatval($res1['total'] ?? 0);

// Soma das despesas
$sql_despesas = "SELECT SUM(valor) as total FROM despesas WHERE id_usuario = ?";
$stmt2 = $conn->prepare($sql_despesas);
$stmt2->bind_param("i", $id_usuario);
$stmt2->execute();
$res2 = $stmt2->get_result()->fetch_assoc();
$despesas = floatval($res2['total'] ?? 0);

// Cálculo do saldo
$saldo = $receitas - $despesas;

echo json_encode([
    "receitas" => $receitas,
    "despesas" => $despesas,
    "saldo" => $saldo
]);
