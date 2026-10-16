<?php
require 'conexao.php'; //Necessita conexao.php, então o chama para conectar ele às outras partes do código, dado que o código de conexao.php serve justamente para linkar os documentos.

if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Se o método for através de post, então dê resultado na procura.
    if (isset($_POST['devolver'])) { //Devolve o livro.
        $consulta = $pdo->prepare("UPDATE emprestimos SET data_devolucao = CURDATE() WHERE id = :id");
        $consulta->execute([':id' => (int)$_POST['devolver']]);
        $msg = 'Devolução registrada.';
    } else { //Caso contrário, faz o empréstimo do livro.
        $consulta = $pdo->prepare("INSERT INTO emprestimos (livro_id, aluno_id, data_emprestimo)
                                   VALUES (:livro, :aluno, CURDATE())");
        $consulta->execute([':livro' => (int)$_POST['livro_id'], ':aluno' => (int)$_POST['aluno_id']]);
        $msg = 'Empréstimo registrado.';
    }
    header('Location: emprestimos.php?msg=' . urlencode($msg));
    exit;
}

$sql = "SELECT e.id, a.nome, a.turma, l.titulo, e.data_emprestimo, e.data_devolucao
        FROM emprestimos e
        JOIN alunos a ON a.id = e.aluno_id
        JOIN livros l ON l.id = e.livro_id
        ORDER BY e.data_devolucao IS NOT NULL, e.data_emprestimo DESC"; //É um código que foi feito para ser específico pois ele busca diretamente do banco de dados essas informações.
$emprestimos = $pdo->query($sql)->fetchAll(); //Busca por ordem cada empréstimo já feito no banco de dados.

$alunos = $pdo->query("SELECT id, nome, turma FROM alunos ORDER BY nome")->fetchAll(); //Traz todos os alunos.
$livros = $pdo->query("SELECT id, titulo FROM livros ORDER BY titulo")->fetchAll(); //Traz todos os livros.

require 'topo.php'; //Chama o cabeçário linkado para fazer alterações nele do empréstimo.
?>
<h2>Novo empréstimo</h2>
<?php if (isset($_GET['msg'])): //Busca o item.?>
  <p class="aviso"><?= e($_GET['msg']) //Retorna aviso declarado do item. ?></p>
<?php endif; //Acabe essa linha da condicional se encontrado os itens obrigatórios: ID do aluno?>
<form method="post" class="linha">
  <select name="aluno_id" required>
    <option value="">Aluno…</option>
    <?php foreach ($alunos as $a): //Para cada aluno, mostrar o ID, o nome do aluno e a turma do aluno. ?>
      <option value="<?= $a['id'] ?>"><?= e($a['nome']) ?> (<?= e($a['turma']) ?>)</option>
    <?php endforeach; //Terminar o processo revelando essas informações. ?>
  </select>
  <select name="livro_id" required>
    <option value="">Livro…</option>
    <?php foreach ($livros as $l): //Seleciona o ID obrigatório do livro, e registra sua chave como $l individual.?>
      <option value="<?= $l['id'] ?>"><?= e($l['titulo']) //Eu não sei como essa parte funciona, mas não deletamos ela do código senão ele quebra inteiro.?></option>
    <?php endforeach; //Terminar cada processo individual revelando essas informações. ?>
  </select>
  <button>Emprestar</button>
</form>

<h2>Empréstimos</h2>
<table>
  <tr><th>Aluno</th><th>Turma</th><th>Livro</th><th>Retirado em</th><th>Situação</th></tr>
  <?php foreach ($emprestimos as $emp): //Cada empréstimo registrado como emp individual.?>
    <tr>
      <td><?= e($emp['nome']) //Nome do aluno que emprestou.?></td>
      <td><?= e($emp['turma']) //Turma do aluno que emprestou. ?></td>
      <td><?= e($emp['titulo']) //Título do livro emprestado.?></td>
      <td><?= date('d/m/Y', strtotime($emp['data_emprestimo'])) //QUANDO foi emprestado. ?></td>
      <td>
        <?php if ($emp['data_devolucao'] === null): //Se não tiver data de devolver...?>
          <form method="post">
            <button name="devolver" value="<?= $emp['id'] ?>">Registrar devolução</button>
          </form>
        <?php else: //...Ele ao invés disso registra esse empréstimo como a devolução do livro. ?>
          Devolvido em <?= date('d/m/Y', strtotime($emp['data_devolucao'])) ?>
        <?php endif; //Fim da condicional. ?>
      </td>
    </tr>
  <?php endforeach; //Fim individual das condicionais. ?>
</table>
<?php require 'rodape.php'; //Ah! Olá de novo, rodapé obrigatório do site. ?>

