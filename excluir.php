<?php

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {   //Só apaga SE o método de pedido foi usando post.
    header('Location: index.php'); //Cabeçário no index.php
    exit;
}

try {
    $consulta = $pdo->prepare("DELETE FROM livros WHERE id = :id"); //Prepara para executar a consulta, verificando se está presente os livros e os IDs
    $consulta->execute([':id' => (int)$_POST['id']]); //Em seguida executa porque estão presentes, caso contrário eu sou burro e o código deu falha por algum motivo.
    $msg = 'Livro excluído.'; //Yay! Você permanentemente mandou uma peça literária para os confins do universo!
} catch (PDOException $erro) { //A menos que isso ocorra.
    $msg = 'Este livro tem empréstimos registrados e não pode ser excluído.'; //Você sabe. Mensagem.
}
header('Location: index.php?msg=' . urlencode($msg)); //Cabeçário 2.0!
exit;
