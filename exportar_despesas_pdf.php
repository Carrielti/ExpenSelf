<?php
require 'libs/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

$id_usuario = $_SESSION['id_usuario'];
$nome_usuario = $_SESSION['nome'];

$sql = "SELECT nome, valor, DATE_FORMAT(data_despesa, '%d/%m/%Y') as data FROM despesas WHERE id_usuario = $id_usuario ORDER BY data_despesa DESC";
$result = $conn->query($sql);

$despesas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $despesas[] = $row;
    }
} else {
    die("Nenhuma despesa encontrada.");
}

$html = '
<!DOCTYPE html>
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; }
    h1 { text-align: center; color: #2980b9; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #555;
    }
    th {
      background-color: #2980b9;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
  <title>ExpenSelf - Despesas - PDF</title>
</head>
<body>
  <h1>Relatório de Despesas - ExpenSelf</h1>
  <p style="text-align: center;">Usuário: <strong>' . htmlspecialchars($nome_usuario) . '</strong></p>
  <table>
    <tr><th>Nome</th><th>Valor (R$)</th><th>Data</th></tr>';

foreach ($despesas as $d) {
    $html .= '<tr>
                <td>' . htmlspecialchars($d['nome']) . '</td>
                <td>' . number_format($d['valor'], 2, ',', '.') . '</td>
                <td>' . $d['data'] . '</td>
              </tr>';
}

$html .= '</table></body></html>';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("despesas_expenSelf.pdf", ["Attachment" => false]);
exit;
?>
