<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $highlight = isset($_POST['highlight']) ? escapeshellarg($_POST['highlight']) : '';

    // Caminho COMPLETO para o Python e script
    $command = escapeshellcmd("C:/Users/user/AppData/Local/Programs/Python/Python313/python.exe C:/xampp/htdocs/ExpenSelf/grafico_despesas.py");
    
    // Adiciona o argumento se houver destaque
    if (!empty($highlight)) {
        $command .= " " . $highlight;
    }

    exec($command, $output, $return_var);

    if ($return_var === 0) {
        header("Location: e_home.php");
        exit();
    } else {
        echo "Erro ao gerar o gráfico.<br>";
        echo "<pre>" . implode("\n", $output) . "</pre>";
    }
} else {
    echo "Acesso inválido.";
}
?>
