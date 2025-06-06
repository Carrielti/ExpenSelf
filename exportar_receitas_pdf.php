<?php
require 'libs/dompdf/autoload.inc.php'; // ajuste se estiver em outro caminho

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();
include("conexao.php");

if (!isset($_SESSION['id_usuario'])) {
    die("Acesso negado.");
}

$id_usuario = $_SESSION['id_usuario'];
$nome_usuario = $_SESSION['nome'];

$sql = "SELECT nome, valor FROM receitas WHERE id_usuario = $id_usuario";
$result = $conn->query($sql);

$receitas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $receitas[] = [
            'nome' => $row['nome'],
            'valor' => floatval($row['valor'])
        ];
    }

    // Ordena do maior para o menor valor
    usort($receitas, fn($a, $b) => $b['valor'] <=> $a['valor']);
} else {
    die("Nenhuma despesa encontrada.");
}

// Criação do HTML
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
  <title>ExpenSelf - Receitas - PDF</title>
  <link rel="icon" href="/img/icone-logo.png" type="image/png">
</head>
<body>
  <h1>Relatório de Receitas - ExpenSelf</h1>
  <p style="text-align: center;">Usuário: <strong>' . htmlspecialchars($nome_usuario) . '</strong></p>
  <table>
    <tr><th>Nome</th><th>Valor (R$)</th></tr>';

foreach ($receitas as $receita) {
    $html .= '<tr>
                <td>' . htmlspecialchars($receita['nome']) . '</td>
                <td>' . number_format($receita['valor'], 2, ',', '.') . '</td>
              </tr>';
}

$html .= '</table></body></html>';

// Instância do Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("receitas_expenSelf.pdf", ["Attachment" => false]); // Exibe direto no navegador
exit;

