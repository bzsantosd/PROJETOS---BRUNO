CREATE DATABASE IF NOT EXISTS TechFit;
USE TechFit;

CREATE TABLE Administrador (
    Id_Administrador INT AUTO_INCREMENT PRIMARY KEY,
    nome_administrador VARCHAR(100) NOT NULL,
    carga_horaria INT NOT NULL,
    salario DECIMAL(10,2),
    email VARCHAR(255)
);

CREATE TABLE Estoque (
    Id_Estoque INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE Treino (
    Id_Treino INT AUTO_INCREMENT PRIMARY KEY,
    objetivo VARCHAR(255),
    repeticoes INT,
    data_inicio DATETIME NOT NULL,
    data_final DATETIME NOT NULL,
    horario_treino TIME
);

CREATE TABLE Exercicio (
    Id_Exercicio INT AUTO_INCREMENT PRIMARY KEY,
    nome_exercicio VARCHAR(100) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    execucao INT
);

CREATE TABLE Instrutor (
    Id_Instrutor INT AUTO_INCREMENT PRIMARY KEY,
    nome_instrutor VARCHAR(100) NOT NULL,
    carga_horaria INT NOT NULL,
    salario DECIMAL(10,2),
    email VARCHAR(255),
    Id_Treino INT,
    FOREIGN KEY (Id_Treino) REFERENCES Treino(Id_Treino)
);

CREATE TABLE Aluno (
    Id_Aluno INT AUTO_INCREMENT PRIMARY KEY,
    nome_aluno VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    contato VARCHAR(100),
    endereco VARCHAR(255),
    email VARCHAR(255),
    Id_Administrador INT,
    FOREIGN KEY (Id_Administrador) REFERENCES Administrador(Id_Administrador)
);

CREATE TABLE Produtos (
    Id_Produtos INT AUTO_INCREMENT PRIMARY KEY,
    nome_produto VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2),
    categoria VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL,
    Id_Administrador INT,
    Id_Estoque INT,
    FOREIGN KEY (Id_Administrador) REFERENCES Administrador(Id_Administrador),
    FOREIGN KEY (Id_Estoque) REFERENCES Estoque(Id_Estoque)
);

CREATE TABLE Vendas (
    Id_Vendas INT AUTO_INCREMENT PRIMARY KEY,
    valor_total DECIMAL(10,2),
    quantidade INT NOT NULL,
    nome_cliente VARCHAR(100) NOT NULL,
    Id_Estoque INT,
    FOREIGN KEY (Id_Estoque) REFERENCES Estoque(Id_Estoque)
);

CREATE TABLE Planos (
    Id_Plano INT AUTO_INCREMENT PRIMARY KEY,
    nome_plano VARCHAR(100) NOT NULL,
    descricao VARCHAR(255),
    duracao DATE,
    valor_mensal DECIMAL(10,2),
    Id_Aluno INT,
    Id_Administrador INT,
    FOREIGN KEY (Id_Aluno) REFERENCES Aluno(Id_Aluno),
    FOREIGN KEY (Id_Administrador) REFERENCES Administrador(Id_Administrador)
);

CREATE TABLE CRIA (
    Id_Exercicio INT,
    Id_Instrutor INT,
    PRIMARY KEY (Id_Exercicio, Id_Instrutor),
    FOREIGN KEY (Id_Exercicio) REFERENCES Exercicio(Id_Exercicio),
    FOREIGN KEY (Id_Instrutor) REFERENCES Instrutor(Id_Instrutor)
);

CREATE TABLE POSSUI (
    Id_Treino INT,
    Id_Aluno INT,
    PRIMARY KEY (Id_Treino, Id_Aluno),
    FOREIGN KEY (Id_Treino) REFERENCES Treino(Id_Treino),
    FOREIGN KEY (Id_Aluno) REFERENCES Aluno(Id_Aluno)
);

CREATE TABLE CONTEM (
    Id_Treino INT,
    Id_Exercicio INT,
    PRIMARY KEY (Id_Treino, Id_Exercicio),
    FOREIGN KEY (Id_Treino) REFERENCES Treino(Id_Treino),
    FOREIGN KEY (Id_Exercicio) REFERENCES Exercicio(Id_Exercicio)
);

SELECT * FROM techfit.administrador;

-- Administradores
INSERT INTO Administrador (nome_administrador, carga_horaria, salario, email) VALUES
('Beatriz Santos', 40, 3500.00, 'beatriz.santos@techfit.com'),
('Vitoria Pereira', 45, 4200.50, 'vitoria.pereira@techfit.com');

-- Estoques
INSERT INTO Estoque () VALUES (), ();

-- Treinos
INSERT INTO Treino (objetivo, repeticoes, data_final, data_inicio, horario_treino) VALUES
('Hipertrofia Muscular', 10, '2025-12-31 00:00:00', '2025-10-15 00:00:00', '08:00:00'),
('Perda de Peso', 15, '2026-03-31 00:00:00', '2025-09-01 00:00:00', '18:30:00');

-- Instrutores
INSERT INTO Instrutor (nome_instrutor, carga_horaria, salario, email, Id_Treino) VALUES
('Beatriz Santos', 40, 3500.00, 'beatriz.instrutor@techfit.com', 1),
('Vitoria Pereira', 45, 4200.50, 'vitoria.instrutor@techfit.com', 2);

-- Alunos
INSERT INTO Aluno (email, endereco, contato, cpf, nome_aluno, Id_Administrador) VALUES
('vitoria@email.com', 'Rua A, 123', '99999-0001', '111.111.111-11', 'Vitoria', 1),
('beatriz@email.com', 'Av. B, 456', '99999-0002', '222.222.222-22', 'Beatriz', 2);

-- Planos
INSERT INTO Planos (nome_plano, descricao, duracao, valor_mensal, Id_Aluno, Id_Administrador) VALUES
('Plano Básico', 'Acesso Livre a Musculação', '0001-01-01', 99.90, 1, 1),
('Plano Plus', 'Avaliação Física a cada 3 meses', '0001-01-01', 159.90, 2, 2),
('Plano Premium', 'Acesso ilimitado + Acompanhamento mensal', '0001-01-01', 219.90, 2, 2);

-- Produtos
INSERT INTO Produtos (nome_produto, preco, categoria, quantidade, Id_Administrador, Id_Estoque) VALUES
('Creatina 300g', 120.00, 'Suplemento', 50, 1, 1),
('Whey Protein 900g Integralmédica', 99.90, 'Suplemento', 30, 2, 2);

-- Vendas
INSERT INTO Vendas (valor_total, quantidade, nome_cliente, Id_Estoque) VALUES
(219.90, 2, 'Beatriz', 1),
(99.90, 1, 'Vitoria', 2);

-- Exercícios
INSERT INTO Exercicio (nome_exercicio, categoria, execucao) VALUES
('Supino Reto Barra', 'Peito', 4),
('Agachamento Livre', 'Pernas', 3);
