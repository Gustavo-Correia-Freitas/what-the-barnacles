<?php

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {   //Só apaga SE o método de pedido foi usando post.
    header('Location: addaluno.php');
    exit;
}

try {
    $consulta = $pdo->prepare("DELETE FROM alunos WHERE id = :id");
    $consulta->execute([':id' => (int)($_POST['id'] ?? 0)]);
    $msg = $consulta->rowCount() ? 'Aluno removido.' : 'Aluno não encontrado.';
} catch (PDOException $erro) {
    $msg = 'Este aluno tem empréstimos registrados e não pode ser excluído.';
}
header('Location: addaluno.php?msg=' . urlencode($msg));
exit;
