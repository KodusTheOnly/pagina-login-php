<?php
// Inclui conexão com banco
include_once("../../config/conexao.php");

// Captura e sanitiza dados do formulário de cadastro
$nome  = isset($_POST["nome"])  ? trim($_POST["nome"])  : "";
$email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$senha = isset($_POST["senha"]) ? $_POST["senha"] : "";

// VALIDAÇÃO 1: Campos obrigatórios
if ($nome === "" || $email === "" || $senha === "") {
    echo "<script>alert('Preencha todos os campos');history.back();</script>";
    exit;
}

// VALIDAÇÃO 2: Formato de e-mail
// FILTER_VALIDATE_EMAIL verifica estrutura válida (usuario@dominio.com)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('E-mail inválido');history.back();</script>";
    exit;
}

// VALIDAÇÃO 3: Senha mínima
// Requisito de segurança: mínimo 6 caracteres
if (strlen($senha) < 6) {
    echo "<script>alert('A senha precisa ter pelo menos 6 caracteres');history.back();</script>";
    exit;
}

// SEGURANÇA: Criptografa senha antes de armazenar
// PASSWORD_DEFAULT usa algoritmo bcrypt (atualmente o mais seguro)
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Insere usuário no banco usando prepared statement
$sql = "INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Verifica se prepared statement foi criado com sucesso
if(!$stmt){
    echo "<h3>Erro ao preparar a query: " . htmlspecialchars($conn->error) . "</h3>";
    exit;
}

// Vincula parâmetros: 'sss' = 3 strings
$stmt->bind_param("sss", $nome, $email, $senha_hash);

// Tenta executar insert
if ($stmt->execute()) {
    // Sucesso: redireciona para login
    echo "<script>alert('Conta criada com sucesso!');window.location.href='login.html';</script>";
} else {
    // Trata erro de email duplicado (código MySQL 1062)
    if ($conn->errno === 1062) {
        echo "<script>alert('Este e-mail já está cadastrado');history.back();</script>";
    } else {
        // Outros erros
        echo "<h3>Erro ao salvar: " . htmlspecialchars($conn->error) . "</h3>";
    }
}

// Fecha recursos
$stmt->close();
$conn->close();
?>