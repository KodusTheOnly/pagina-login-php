<?php
// Gerenciamento de sessão e controle de acesso
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

// Verifica se o usuário está logado
function is_logged_in(): bool {
  return isset($_SESSION['user']);
}

// Caminho base do projeto relativo ao DOCUMENT_ROOT (permite mover a pasta sem quebrar os redirecionamentos)
function project_base_uri(): string {
  static $baseUri = null;
  if ($baseUri !== null) {
    return $baseUri;
  }

  $projectRoot = realpath(__DIR__ . '/..') ?: '';
  $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
  $projectRoot = str_replace('\\', '/', $projectRoot);
  $documentRoot = $documentRoot ? str_replace('\\', '/', realpath($documentRoot) ?: $documentRoot) : '';

  if ($documentRoot && strpos($projectRoot, $documentRoot) === 0) {
    $relative = substr($projectRoot, strlen($documentRoot));
  } else {
    $relative = '/' . basename($projectRoot);
  }

  $relative = trim($relative, '/');
  if ($relative === '') {
    $baseUri = '/';
    return $baseUri;
  }

  $segments = array_filter(explode('/', $relative), 'strlen');
  $baseUri = '/' . implode('/', array_map('rawurlencode', $segments));
  return $baseUri;
}

// Caminho do formulário de login dentro da nova estrutura
function login_path(): string {
  $baseUri = rtrim(project_base_uri(), '/');
  return ($baseUri === '' ? '' : $baseUri) . '/modules/autenticacao/login.html';
}

// Redireciona para login se não estiver autenticado
function require_login(): void {
  if (!is_logged_in()) {
    header('Location: ' . login_path());
    exit;
  }
}

// Valida se o usuário tem o perfil necessário (ADMIN ou OPERADOR)
function require_role(string $role): void {
  require_login();
  if (($_SESSION['user']['perfil'] ?? '') !== $role) {
    http_response_code(403);
    echo 'Acesso negado. Perfil insuficiente.';
    exit;
  }
}
