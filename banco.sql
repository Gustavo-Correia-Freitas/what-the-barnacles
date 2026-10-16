
-- Banco de dados biblioteca apresentado na aula do professor e encontrado no Classroom.

DROP DATABASE IF EXISTS biblioteca; -- Deleta uma biblioteca anterior. IMPORTANTE: REMOVA OU FACA BACKUP DE BIBLIOTECAS ANTERIORES PARA NAO PERDER PROGRESSO!!!!
CREATE DATABASE biblioteca CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; -- Substitui a biblioteca antiga e apagada com uma nova.
USE biblioteca; -- Agora que biblioteca esta presente, vai executar os seguintes comandos nela.

CREATE TABLE livros (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  titulo      VARCHAR(150) NOT NULL,
  autor       VARCHAR(100) NOT NULL,
  ano         INT,
  genero      VARCHAR(50),
  quantidade  INT NOT NULL DEFAULT 1
) ENGINE=InnoDB;
-- A tabela dos livros da nossa biblioteca. E auto-explanatório; E uma biblioteca, afinal de contas...
CREATE TABLE alunos (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  nome   VARCHAR(100) NOT NULL,
  turma  VARCHAR(20) NOT NULL
) ENGINE=InnoDB;
-- Os alunos da nossa biblioteca escolar que quiserem emprestar os livros. Sou so eu que estranho o fato que somente alunos estao fazendo emprestimos?
CREATE TABLE emprestimos (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  livro_id         INT NOT NULL,
  aluno_id         INT NOT NULL,
  data_emprestimo  DATE NOT NULL,
  data_devolucao   DATE NULL,
  FOREIGN KEY (livro_id) REFERENCES livros(id),
  FOREIGN KEY (aluno_id) REFERENCES alunos(id)
) ENGINE=InnoDB;

INSERT INTO livros (titulo, autor, ano, genero, quantidade) VALUES
('A Culpa é Das Estrelas', 'John Green', 2012, 'Romance', 5), 
('A Menina que Roubava Livros', 'Markus Zusak', 2005, 'Romance', 2), 
('O Diário de uma Princesa Desastrada', 'Maidy Lacerda', 2022, 'Literatura Fantástica', 3), 
('O Diário de um Banana 1', 'Jeff Kinney', 2007, 'Humor', 4), 
('O Diário de um Banana 2', 'Jeff Kinney', 2007, 'Humor', 3), 
('O Diário de um Banana 3', 'Jeff Kinney', 2007, 'Humor', 2),
('Toda Mafalda', 'Quino', 1978, 'Quadrinhos', 3),
('O Pequeno Príncipe', 'Antoine de Saint-Exupery', 1943, 'Literatura Fantástica', 1),
('A Chapeuzinho Vermelho', 'Conto de Fadas', 901, 'Conto', 2),
('Grande Sertão: Veredas', 'João Guimarães Rosa', 1956, 'Romance', 1),
('Auto da Compadecida', 'Ariano Suassuna', 1955, 'Teatro', 2), 
('A Moreninha', 'Joaquim Manuel de Macedo', 1844, 'Romance', 1);

INSERT INTO alunos (nome, turma) VALUES
('Isac Camargo', '1D'), ('Joao Vitor', '2A'), ('Carlinhos', '2B'), ('Diego Rocha', '2B'),
('Eduarda Alves', '3A'), ('Pedro Paulo', '3A'), ('Gabriela Nunes', '3B'), ('Henrique Dias', '3B');

INSERT INTO emprestimos (livro_id, aluno_id, data_emprestimo, data_devolucao) VALUES
(1, 1, '2013-09-11', '2026-09-15'),
(6, 2, '2026-09-10', NULL),
(1, 3, '2026-09-20', NULL),
(9, 5, '2026-09-22', NULL),
(7, 4, '2026-09-05', '2026-09-19'),
(11, 7, '2026-10-01', NULL);
