-- Geração de Modelo físico
-- Sql ANSI 2003 - brModelo.



CREATE TABLE Planos (
duracao date,
descricao varchar (255),
valor_mensal decimal (5,2),
Id_plano int auto_increment primary key PRIMARY KEY,
nome_plano varchar (100) not null,
Id_Aluno int auto_increment primary key,
Id_Administrador int auto_increment primary key
)

CREATE TABLE Vendas (
quantidade int not null,
Id_Vendas int auto_increment primary key PRIMARY KEY,
valor_total decimal (5,2),
nome_cliente varchar (100) not null
)

CREATE TABLE Produtos (
Id_Produtos int auto_increment primary key PRIMARY KEY,
quantidade int not null,
nome_produto varchar (100) not null,
preco decimal (5,2),
categoria varchar (100) not null,
Id_Administrador int auto_increment primary key
)

CREATE TABLE Administrador+Instrutor+Aluno (
salario decimal (5,2),
email varchar (255),
carga_horaria int not null,
nome_administrador varchar (100),
Id_Administrador int auto_increment primary key,
-- Erro: nome do campo duplicado nesta tabela!
salario decimal (5,2),
-- Erro: nome do campo duplicado nesta tabela!
carga_horaria int not null,
-- Erro: nome do campo duplicado nesta tabela!
Id_Administrador int auto_increment primary key,
-- Erro: nome do campo duplicado nesta tabela!
email varchar (255),
-- Erro: nome do campo duplicado nesta tabela!
nome_administrador varchar (100) not null,
-- Erro: nome do campo duplicado nesta tabela!
email varchar (255),
Id_Aluno int auto_increment primary key,
contato varchar (100),
nome_aluno varchar (100) not null,
endereco varchar (255),
cpf varchar (14)  not null,
Id_Treino int auto_increment primary key,
PRIMARY KEY(Id_Administrador,Id_Administrador,Id_Aluno)
)

CREATE TABLE Treino (
Id_Treino int auto_increment primary key PRIMARY KEY,
repeticoes decimal (5,2),
data_inicio datetime not null,
horario_treino date,
objetivo varchar (255),
data_final datetime not null
)

CREATE TABLE Exercicio (
Id_Exercicio int auto_increment primary key PRIMARY KEY,
categoria varchar (100) not null,
execucao decimal (5,2),
nome_exercicio varchar (100) not null,
Id_Administrador int auto_increment primary key,
Id_Aluno int auto_increment primary key,
FOREIGN KEY(/*erro: ??*/) REFERENCES Administrador+Instrutor+Aluno (Id_Administrador,Id_Administrador,Id_Aluno)
)

CREATE TABLE REALIZA (
Id_Vendas int auto_increment primary key,
Id_Produtos int auto_increment primary key,
FOREIGN KEY(Id_Vendas) REFERENCES Vendas (Id_Vendas),
FOREIGN KEY(Id_Produtos) REFERENCES Produtos (Id_Produtos)
)

CREATE TABLE ATRAEM (
Id_Vendas int auto_increment primary key,
FOREIGN KEY(Id_Vendas) REFERENCES Vendas (Id_Vendas)
)

CREATE TABLE CONTÉM (
Id_Exercicio int auto_increment primary key,
Id_Treino int auto_increment primary key,
FOREIGN KEY(Id_Exercicio) REFERENCES Exercicio (Id_Exercicio)/*falha: chave estrangeira*/
)

ALTER TABLE Planos ADD FOREIGN KEY(/*erro: ??*/) REFERENCES Administrador+Instrutor+Aluno (Id_Administrador,Id_Administrador,Id_Aluno)
ALTER TABLE Administrador+Instrutor+Aluno ADD FOREIGN KEY(Id_Treino) REFERENCES Treino (Id_Treino)
