-- Geração de Modelo físico
-- Sql ANSI 2003 - brModelo.
CREATE DATABASE TechFit;
USE TechFit;
SELECT DATABASE();


CREATE TABLE Administrador (
Id_Administrador int auto_increment primary key PRIMARY KEY,
nome_administrador varchar (100),
carga_horaria int not null,
salario decimal (5,2),
email varchar (255)
);


CREATE TABLE Estoque (
Id_Estoque int auto_increment primary key
);


CREATE TABLE Produtos (
Id_Produtos int auto_increment primary key ,
nome_produto varchar (100) not null,
preco decimal (5,2),
categoria varchar (100) not null,
quantidade int not null,
Id_Administrador int,
Id_Estoque int,
FOREIGN KEY(Id_Administrador) REFERENCES Administrador (Id_Administrador),
FOREIGN KEY(Id_Estoque) REFERENCES Estoque (Id_Estoque)
);

CREATE TABLE Vendas (
valor_total decimal (5,2),
quantidade int not null,
nome_cliente varchar (100) not null,
Id_Vendas int auto_increment primary key ,
Id_Estoque int,
FOREIGN KEY(Id_Estoque) REFERENCES Estoque (Id_Estoque)
);

CREATE TABLE Aluno (
email varchar (255),
endereco varchar (255),
contato varchar (100),
cpf varchar (14)  not null,
nome_aluno varchar (100) not null,
Id_Aluno int auto_increment primary key PRIMARY KEY,
Id_Administrador int,
FOREIGN KEY(Id_Administrador) REFERENCES Administrador (Id_Administrador)
);

CREATE TABLE Instrutor (
Id_Instrutor int auto_increment primary key PRIMARY KEY,
nome_instrutor varchar (100) not null,
carga_horaria int not null,
salario decimal (5,2),
email varchar (255),
Id_Treino int,
FOREIGN KEY(Id_Treino) REFERENCES Treino (Id_Treino)
);

CREATE TABLE Treino (
objetivo varchar (255),
repeticoes decimal (5,2),
data_final datetime not null,
data_inicio datetime not null,
horario_treino date,
Id_Treino int auto_increment primary key
);

CREATE TABLE Planos (
Id_plano int auto_increment primary key,
nome_plano varchar (100) not null,
descricao varchar (255),
duracao date,
valor_mensal decimal (5,2),
Id_Aluno int,
Id_Administrador int,
FOREIGN KEY(Id_Aluno) REFERENCES Aluno (Id_Aluno),
FOREIGN KEY(Id_Administrador) REFERENCES Administrador (Id_Administrador)
);

CREATE TABLE Exercicio (
Id_Exercicio int auto_increment primary key PRIMARY KEY,
nome_exercicio varchar (100) not null,
categoria varchar (100) not null,
execucao decimal (5,2)
);



CREATE TABLE CRIA (
Id_Exercicio int,
Id_Administrador int,
FOREIGN KEY(Id_Exercicio) REFERENCES Exercicio (Id_Exercicio),
FOREIGN KEY(Id_Administrador) REFERENCES Instrutor (Id_Administrador)
);

CREATE TABLE POSSUI (
Id_Treino int,
Id_Aluno int auto_increment primary key,
FOREIGN KEY(Id_Treino) REFERENCES Treino (Id_Treino),
FOREIGN KEY(Id_Aluno) REFERENCES Aluno (Id_Aluno)
);

CREATE TABLE CONTÉM (
Id_Treino int auto_increment primary key,
Id_Exercicio int auto_increment primary key,
FOREIGN KEY(Id_Treino) REFERENCES Treino (Id_Treino),
FOREIGN KEY(Id_Exercicio) REFERENCES Exercicio (Id_Exercicio)
);

ALTER TABLE Produtos ADD FOREIGN KEY(Id_Estoque) REFERENCES Estoque (Id_Estoque);
ALTER TABLE Vendas ADD FOREIGN KEY(Id_Estoque) REFERENCES Estoque (Id_Estoque);
ALTER TABLE Aluno ADD FOREIGN KEY(Id_Administrador) REFERENCES Instrutor (Id_Administrador);
ALTER TABLE Instrutor ADD FOREIGN KEY(Id_Treino) REFERENCES Treino (Id_Treino);

INSERT INTO Administrador (nome_administrador, carga_horaria, salario, email) VALUES
('Beatriz Santos', 40, 3500.00, 'beatriz.santos@techfit.com');

INSERT INTO Administrador (nome_administrador, carga_horaria, salario, email) VALUES
('Vitoria Pereira', 45, 4200.50, 'vitoria.pereira@techfit.com');

INSERT INTO Estoque () VALUES ();
INSERT INTO Estoque () VALUES ();

INSERT INTO Treino (objetivo, repeticoes, data_final, data_inicio, horario_treino) VALUES
('Hipertrofia Muscular', 10.00, '2025-12-31', '2025-10-15', '08:00:00');

INSERT INTO Treino (objetivo, repeticoes, data_final, data_inicio, horario_treino) VALUES
('Perda de Peso', 15.00, '2026-03-31 ', '2025-09-01 ', '18:30:00');

INSERT INTO Instrutor (Id_Administrador, nome_administrador, carga_horaria, salario, email, Id_Treino) VALUES
(1, 'Beatriz Santos', 40, 3500.00, 'beatriz.instrutor@techfit.com', 1);

INSERT INTO Instrutor (Id_Administrador, nome_administrador, carga_horaria, salario, email, Id_Treino) VALUES
(2, 'Vitoria Pereira', 45, 4200.50, 'vitoria.instrutor@techfit.com', 2);

INSERT INTO Aluno (email, endereco, contato, cpf, nome_aluno, Id_Administrador) VALUES
('vitoria@email.com', 'Rua A, 123', '99999-0001', '111.111.111-11', 'Vitoria', 1);

INSERT INTO Aluno (email, endereco, contato, cpf, nome_aluno, Id_Administrador) VALUES
('beatriz@email.com', 'Av. B, 456', '99999-0002', '222.222.222-22', 'Beatriz', 2);

INSERT INTO Planos (nome_plano, descricao, duracao, valor_mensal, Id_Aluno, Id_Administrador) VALUES
('Plano Básico', 'Acesso Livre a Musculação', '0001-00-00', 99.90, 1, 1);

INSERT INTO Planos (nome_plano, descricao, duracao, valor_mensal, Id_Aluno, Id_Administrador) VALUES
('Plano Plus', 'Avaliação Fisica a cada 3 meses', '0001-00-00', 159.90, 2, 2);

INSERT INTO Planos (nome_plano, descricao, duracao, valor_mensal, Id_Aluno, Id_Administrador) VALUES
('Plano Premium', 'Acesso ilimitado + Acompanhamento mensal', '0001-00-00', 219.90, 2, 2);

INSERT INTO Produtos (nome_produto, preco, categoria, quantidade, Id_Administrador, Id_Estoque) VALUES
('Creatina 300g', 120.00, 'Suplemento', 50, 1, 1);

INSERT INTO Produtos (nome_produto, preco, categoria, quantidade, Id_Administrador, Id_Estoque) VALUES
('Whey Protein 900g Integralmédica', 99.90, 'Suplemento', 30, 2, 2);

INSERT INTO Vendas (valor_total, quantidade, nome_cliente, Id_Estoque) VALUES
(219.90, 2, 'Beatriz', 1);

INSERT INTO Vendas (valor_total, quantidade, nome_cliente, Id_Estoque) VALUES
(99.90, 1, 'Vitoria', 2);

INSERT INTO Exercicio (nome_exercicio, categoria, execucao) VALUES
('Supino Reto Barra', 'Peito', 4.00);

INSERT INTO Exercicio (nome_exercicio, categoria, execucao) VALUES
('Agachamento Livre', 'Pernas', 3.00);
