<?php
// Inclui arquivo de conexão com banco de dados
include_once '../../config/conexao.php';

// Inicia sessão PHP se ainda não estiver ativa
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

// Captura e sanitiza dados enviados pelo formulário
// trim() remove espaços em branco no início e fim
// ?? '' define valor padrão como string vazia se não existir
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

// VALIDAÇÃO 1: Verifica se campos foram preenchidos
if ($email === '' || $senha === '') {
  // Exibe alerta JavaScript e retorna para página anterior
  echo "<script>alert('Informe e-mail e senha');history.back();</script>";
  exit; // Interrompe execução do script
}

// VALIDAÇÃO 2: Busca usuário no banco de dados
// Usa prepared statement para prevenir SQL Injection
$stmt = $conn->prepare("SELECT id, nome, email, senha_hash, perfil FROM usuarios WHERE email = ?");
$stmt->bind_param('s', $email); // 's' indica que o parâmetro é string
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc(); // Retorna array associativo ou null

// VALIDAÇÃO 3: Verifica se usuário existe e senha está correta
// password_verify() compara senha em texto plano com hash armazenado
if ($user && password_verify($senha, $user['senha_hash'])) {
  // SEGURANÇA: Regenera ID da sessão para prevenir session fixation
  session_regenerate_id(true);
  
  // Armazena dados do usuário na sessão
  $_SESSION['user'] = [
    'id'     => (int)$user['id'],    // Converte para inteiro
    'nome'   => $user['nome'],
    'email'  => $user['email'],
    'perfil' => $user['perfil'],     // ADMIN ou OPERADOR
  ];
  
  // Redireciona para página de boas-vindas
  header('Location: boas-vindas.php');
  exit;
}

// Se chegou aqui, credenciais são inválidas
// Mensagem genérica por segurança (não revela se email existe)
echo "<script>alert('Credenciais inválidas');history.back();</script>";
?>