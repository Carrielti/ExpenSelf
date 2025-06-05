<?php
require 'libs/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml('<h1>Teste PDF</h1><p>PDF gerado com sucesso!</p>');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("teste.pdf", ["Attachment" => false]);
exit;
