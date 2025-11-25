CREATE DATABASE Login;
USE Login;
-- Usuários do sistema
CREATE TABLE usuarios (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  senha_hash VARCHAR(255) NOT NULL,
  perfil ENUM('ADMIN', 'OPERADOR') NOT NULL DEFAULT 'OPERADOR',
  criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atualizado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uniq_usuarios_email (email)
);
-- Tokens usados no fluxo de recuperação de senha
CREATE TABLE senha_tokens (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  usuario_id INT UNSIGNED NOT NULL,
  token CHAR(64) NOT NULL,
  expira_em DATETIME NOT NULL,
  usado_em DATETIME DEFAULT NULL,
  criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uniq_senha_tokens_token (token),
  KEY idx_senha_tokens_usuario (usuario_id),
  CONSTRAINT fk_senha_tokens_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    ON DELETE CASCADE
);