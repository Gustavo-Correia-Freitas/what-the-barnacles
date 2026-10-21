<?php

require 'conexao.php'; //Demanda conexão.php estar em função. Se inexistente, não ocorre.

$alunos = $_GET['alunos'] ?? '';   // Faz uma busca do texto, existente ou vazio.

$sql = "SELECT a.id, a.nome, a.turma
        GROUP BY a.id, a.nome, a.turma
        ORDER BY a.nome";
//Uma lista específica dos livros, devoluções, autores e empréstimos; quantidade também.

$consulta = $pdo->prepare($sql);   //Prepara a consulta com espaços reservados.
$livros = $consulta->fetchAll(); //Traz todas as partes necessárias através da consulta, fetchAll serve para coletar tudo.

require 'topo.php'; //Demanda topo.php estar em função, chamando-o e em seguida executando essa linha de código.
?>
<form method="get" class="busca">
  <input type="text" name="busca" value="<?= e($busca) ?>" placeholder="Buscar por título ou autor">
  <button>Buscar</button>
</form>

<?php if (isset($_GET['msg'])): ?>
  <p class="aviso"><?= e($_GET['msg']) ?></p>
<?php endif; ?>

<table>
  <tr><th>Nome</th><th>Turma</th><th>Empréstimos</th><th>Disponíveis</th></tr>
  <?php foreach ($livros as $livro): ?>
    <tr>
      <td><?= e($livro['titulo']) ?></td>
      <td><?= e($livro['autor']) ?></td>
      <td><?= e($livro['ano']) ?></td>
      <td><?= e($livro['genero']) ?></td>
      <td><?= $livro['quantidade'] - $livro['emprestados'] ?> de <?= $livro['quantidade'] ?></td>
      <td class="acoes">
        <a href="editar.php?id=<?= $livro['id'] ?>">Editar</a>
        <form method="post" action="excluir.php" onsubmit="return confirm('Excluir este livro?')">
          <input type="hidden" name="id" value="<?= $livro['id'] ?>">
          <button class="perigo">Excluir</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<p class="total"><?= count($livros) ?> aluno(s) encontrado(s).</p>
<?php require 'rodape.php'; ?>

