-- Criação do Banco de Dados TechFit
CREATE DATABASE IF NOT EXISTS TechFit;
USE TechFit;

-- Tabela de Usuários (para login/cadastro)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) UNIQUE,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'admin') DEFAULT 'cliente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    descricao TEXT,
    imagem VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Planos
CREATE TABLE IF NOT EXISTS planos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    beneficios TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir um usuário admin padrão (senha: admin123)
INSERT INTO users (nome, email, senha, tipo) VALUES 
('Administrador', 'admin@techfit.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Inserir alguns produtos de exemplo
INSERT INTO produtos (nome, preco, descricao, imagem) VALUES
('Whey Protein 900g', 99.90, 'Proteína de alta qualidade para ganho de massa muscular', 'https://via.placeholder.com/300x300?text=Whey+Protein'),
('Creatina 300g', 120.00, 'Aumenta força e performance nos treinos', 'https://via.placeholder.com/300x300?text=Creatina'),
('BCAA 120 caps', 79.90, 'Aminoácidos essenciais para recuperação muscular', 'https://via.placeholder.com/300x300?text=BCAA');

-- Inserir alguns planos de exemplo
INSERT INTO planos (titulo, valor, beneficios) VALUES
('Plano Básico', 99.90, 'Acesso livre à musculação\nAcesso durante horário comercial\nArmário individual'),
('Plano Plus', 159.90, 'Tudo do Plano Básico\nAvaliação física trimestral\nAcesso a aulas coletivas\n1 sessão de personal trainer/mês'),
('Plano Premium', 219.90, 'Tudo do Plano Plus\nAcesso 24 horas\nAcompanhamento nutricional mensal\n4 sessões de personal trainer/mês\nÁrea VIP');