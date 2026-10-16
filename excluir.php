<?php

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {   //Só apaga dado o método específico de deleção.
    header('Location: index.php');
    exit;
}

try {
    $consulta = $pdo->prepare("DELETE FROM livros WHERE id = :id");
    $consulta->execute([':id' => (int)$_POST['id']]);
    $msg = 'Livro excluído.';
} catch (PDOException $erro) {
    $msg = 'Este livro tem empréstimos registrados e não pode ser excluído.';
}
header('Location: index.php?msg=' . urlencode($msg));
exit;
