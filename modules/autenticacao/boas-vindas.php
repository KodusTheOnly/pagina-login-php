<?php
// Inicia sessão PHP
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

// Verifica se usuário está autenticado
if (!isset($_SESSION['user'])) {
  // Se não estiver autenticado, redireciona para login
  header('Location: login.html');
  exit;
}

// Obtém dados do usuário da sessão
$usuario = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bem-vindo</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: white;
      border-radius: 10px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      padding: 50px 40px;
      text-align: center;
      max-width: 500px;
      width: 100%;
    }

    h1 {
      color: #333;
      margin-bottom: 20px;
      font-size: 32px;
    }

    .welcome-message {
      color: #667eea;
      font-size: 24px;
      margin-bottom: 30px;
      font-weight: 300;
    }

    .user-info {
      background: #f5f5f5;
      padding: 20px;
      border-radius: 8px;
      margin-bottom: 30px;
      text-align: left;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 12px;
      font-size: 14px;
    }

    .info-row strong {
      color: #333;
    }

    .info-row span {
      color: #666;
    }

    .btn-container {
      display: flex;
      gap: 10px;
      justify-content: center;
    }

    .btn {
      padding: 12px 30px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .btn-primary {
      background: #667eea;
      color: white;
    }

    .btn-primary:hover {
      background: #5568d3;
    }

    .btn-secondary {
      background: #f0f0f0;
      color: #333;
    }

    .btn-secondary:hover {
      background: #e0e0e0;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Boas-vindas!</h1>
    <p class="welcome-message"><?php echo htmlspecialchars($usuario['nome']); ?></p>

    <div class="user-info">
      <div class="info-row">
        <strong>E-mail:</strong>
        <span><?php echo htmlspecialchars($usuario['email']); ?></span>
      </div>
      <div class="info-row">
        <strong>Perfil:</strong>
        <span><?php echo htmlspecialchars($usuario['perfil']); ?></span>
      </div>
    </div>

    <div class="btn-container">
      <a href="logout.php" class="btn btn-secondary">Sair</a>
    </div>
  </div>
</body>
</html>
