<?php
// Conexão com o banco de dados da aplicação
define("HOST", "localhost");
define("PORT", "3307");
define("USER", "root");
define("PAS", "");
define("BASE", "Login");

$conn = new mysqli(HOST, USER, PAS, BASE, PORT);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
