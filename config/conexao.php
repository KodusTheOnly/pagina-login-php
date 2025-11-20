<?php
// Define constantes de conexão com o banco de dados
// HOST: endereço do servidor MySQL (localhost = máquina local)
define("HOST", "localhost");

// PORT: porta customizada 3307 (padrão seria 3306)
// Útil quando há múltiplas instâncias do MySQL ou conflitos de porta
define("PORT", "3307");

// USER: usuário do banco (root = administrador)
define("USER", "root");

// PAS: senha do usuário (vazia em ambientes de desenvolvimento local)
define("PAS", "");

// BASE: nome do banco de dados que será utilizado
define("BASE", "Login");

// Cria conexão usando MySQLi (MySQL Improved Extension)
// Passa host, usuário, senha, nome do banco e porta
$conn = new mysqli(HOST, USER, PAS, BASE, PORT);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    // Encerra execução e exibe mensagem de erro
    die("Falha na conexão: " . $conn->connect_error);
}

// Define charset UTF-8 para suportar caracteres especiais e acentuação
// utf8mb4 é mais completo que utf8, suportando emojis e caracteres especiais
$conn->set_charset("utf8mb4");
?>