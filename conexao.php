<?php
// Conectar ao banco de dados

$servername = "sql113.infinityfree.com";
$username = "if0_39027470";
$password = "expenself01"; // senha padrão do XAMPP (vazia)
$database = "if0_39027470_bd_expenself"; // nome correto do banco que você criou

// Criar conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>