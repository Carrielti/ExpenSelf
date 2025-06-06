<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $url = "https://expenself.onrender.com/excluir/$id";

    $options = [
        "http" => [
            "method"  => "DELETE"
        ]
    ];

    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === FALSE) {
        header("Location: listar_despesas_firebase.php?msg=erro");
        exit;
    } else {
        header("Location: listar_despesas_firebase.php?msg=excluida");
        exit;
    }
}
?>
