-- ============================================
-- CRIAR BANCO DE DADOS
-- ============================================
CREATE DATABASE IF NOT EXISTS biblioteca;

USE biblioteca;

-- ============================================
-- TABELA DE USUÁRIOS
-- ============================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'aluno') NOT NULL DEFAULT 'aluno',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_tipo (tipo)
);

-- ============================================
-- TABELA DE LIVROS
-- ============================================
CREATE TABLE IF NOT EXISTS livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    disponivel BOOLEAN DEFAULT TRUE,
    imagem VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_titulo (titulo),
    INDEX idx_autor (autor),
    INDEX idx_disponivel (disponivel)
);

-- ============================================
-- TABELA DE ALUGUÉIS
-- ============================================
CREATE TABLE IF NOT EXISTS alugueis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_livro INT NOT NULL,
    data_aluguel DATE NOT NULL,
    data_devolucao DATE NOT NULL,
    devolvido BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_livro) REFERENCES livros(id) ON DELETE CASCADE,
    INDEX idx_usuario (id_usuario),
    INDEX idx_livro (id_livro),
    INDEX idx_devolvido (devolvido),
    INDEX idx_data_devolucao (data_devolucao)
);

-- ============================================
-- DADOS INICIAIS
-- ============================================

-- Inserir usuário ADMIN padrão (senha: admin123)
INSERT INTO usuarios (nome, email, senha, tipo) 
VALUES (
    'Administrador', 
    'admin@biblioteca.com', 
    'admin123', 
    'admin'
);

-- Inserir usuário ALUNO de teste
-- Email: aluno@teste.com
-- Senha: aluno123 (hash de exemplo)
INSERT INTO usuarios (nome, email, senha, tipo) 
VALUES (
    'Aluno Teste', 
    'aluno@teste.com', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'aluno'
);

-- Inserir alguns livros de exemplo
INSERT INTO livros (titulo, autor, disponivel) VALUES
    ('1984', 'George Orwell', 1),
    ('Dom Casmurro', 'Machado de Assis', 1),
    ('O Senhor dos Anéis', 'J.R.R. Tolkien', 1),
    ('Harry Potter e a Pedra Filosofal', 'J.K. Rowling', 1),
    ('O Pequeno Príncipe', 'Antoine de Saint-Exupéry', 1);

-- ============================================
-- VERIFICAR CRIAÇÃO
-- ============================================
SELECT 'Banco de dados criado com sucesso!' AS status;
SELECT COUNT(*) AS total_usuarios FROM usuarios;
SELECT COUNT(*) AS total_livros FROM livros;