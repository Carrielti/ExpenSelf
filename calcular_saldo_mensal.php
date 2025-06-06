<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(["erro" => "Acesso negado. Faça login."]);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Pega mês e ano atual se não forem passados via GET
$mes = isset($_GET['mes']) ? intval($_GET['mes']) : date('m');
$ano = isset($_GET['ano']) ? intval($_GET['ano']) : date('Y');

// Receita total do mês
$sqlReceita = "SELECT SUM(valor) as total_receita FROM receitas 
               WHERE id_usuario = ? AND MONTH(data_receita) = ? AND YEAR(data_receita) = ?";
$stmt1 = $conn->prepare($sqlReceita);
$stmt1->bind_param("iii", $id_usuario, $mes, $ano);
$stmt1->execute();
$result1 = $stmt1->get_result();
$total_receita = $result1->fetch_assoc()['total_receita'] ?? 0;

// Despesa total do mês
$sqlDespesa = "SELECT SUM(valor) as total_despesa FROM despesas 
               WHERE id_usuario = ? AND MONTH(data_despesa) = ? AND YEAR(data_despesa) = ?";
$stmt2 = $conn->prepare($sqlDespesa);
$stmt2->bind_param("iii", $id_usuario, $mes, $ano);
$stmt2->execute();
$result2 = $stmt2->get_result();
$total_despesa = $result2->fetch_assoc()['total_despesa'] ?? 0;

// Cálculo do saldo
$saldo = $total_receita - $total_despesa;

// Retorna em JSON
echo json_encode([
    "ano" => $ano,
    "mes" => $mes,
    "receita" => number_format($total_receita, 2, ',', '.'),
    "despesa" => number_format($total_despesa, 2, ',', '.'),
    "saldo" => number_format($saldo, 2, ',', '.')
]);

$conn->close();
?>
