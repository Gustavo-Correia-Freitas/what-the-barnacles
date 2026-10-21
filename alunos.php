<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO alunos (nome, turma)
            VALUES (:nome, :turma)";
    $consulta = $pdo->prepare($sql);
    $consulta->execute([
        ':nome'     => $_POST['nome'],
        ':turma'      => $_POST['turma'],
    ]);
    header('Location: index.php?msg=' . urlencode('Aluno cadastrado!'));
    exit;
}

require 'topo.php';
?>
<h2>Novo aluno</h2>
<form method="post" class="ficha">
  <label>Nome <input name="nome" required maxlength="100"></label>
  <label>Turma <input name="turma" required maxlength="20"></label>
  <button>Salvar</button>
</form>
<?php require 'rodape.php'; ?>
