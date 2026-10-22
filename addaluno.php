<?php

require 'conexao.php';

$busca = $_GET['busca'] ?? '';

$sql = "SELECT id, nome, turma
        FROM alunos
        WHERE nome LIKE :busca OR turma LIKE :busca2
        ORDER BY nome";
$consulta = $pdo->prepare($sql);
$consulta->execute([':busca' => "%$busca%", ':busca2' => "%$busca%"]);
$alunos = $consulta->fetchAll();

require 'topo.php';
?>
<form method="get" class="busca">
  <input type="text" name="busca" value="<?= e($busca) ?>" placeholder="Buscar por nome ou turma">
  <button>Buscar</button>
</form>

<?php if (isset($_GET['msg'])): ?>
  <p class="aviso"><?= e($_GET['msg']) ?></p>
<?php endif; ?>

<table>
  <tr><th>Nome</th><th>Turma</th><th></th></tr>
  <?php foreach ($alunos as $aluno): ?>
    <tr>
      <td><?= e($aluno['nome']) ?></td>
      <td><?= e($aluno['turma']) ?></td>
      <td class="acoes">
        <form method="post" action="excluiralu.php" onsubmit="return confirm('Excluir este aluno?')">
          <input type="hidden" name="id" value="<?= $aluno['id'] ?>">
          <button class="perigo">Excluir</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<p class="total"><?= count($alunos) ?> aluno(s) encontrado(s).</p>
<?php require 'rodape.php'; ?>

