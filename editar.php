<?php
require 'conexao.php'; //Conexão, e tudo mais... Eu preciso explicar essa parte de novo?

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0); //Seleciona do ID para postagens e então dá procedimento com usá-los/editá-los.

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Necessita o estilo de pedido ser diretamente de Post, caso contrário não roda.
    $sql = "UPDATE livros
            SET titulo = :titulo, autor = :autor, ano = :ano, genero = :genero, quantidade = :quantidade
            WHERE id = :id"; //Se não ter WHERE, o código estaria em risco. Ah, e ele também atualiza os livros.
    $consulta = $pdo->prepare($sql); //Consulta e então prepara. É. Você sabe.
    $consulta->execute([
        ':titulo'     => $_POST['titulo'], //Título editável do livro.
        ':autor'      => $_POST['autor'], //Autor editável do livro.
        ':ano'        => $_POST['ano'] !== '' ? (int)$_POST['ano'] : null, //O ano lançado.
        ':genero'     => $_POST['genero'], //A orientação sexual do livro. (Sim, isso foi uma piada.)
        ':quantidade' => (int)$_POST['quantidade'], //Quantidade do livro.
        ':id'         => $id, //Código pelo qual chaves identificam e fazem empréstimo do livro.
    ]);
    header('Location: index.php?msg=' . urlencode('Livro atualizado!')); //Yay! :D
    exit;
}

$consulta = $pdo->prepare("SELECT * FROM livros WHERE id = :id"); //Consulta livros específicos a partir do ID.
$consulta->execute([':id' => $id]);
$livro = $consulta->fetch(); //Busca o livro.
if (!$livro) { //Se não ter;
    die('Livro não encontrado.'); //Cancele a busca com "die" e mostre a razão do porquê.
}

require 'topo.php'; //Chama topo.php para a função, de forma onde seja possível editar os detalhes e informações abaixo inclusos no topo.php.
?>
<h2>Editar livro</h2>
<form method="post" class="ficha">
  <input type="hidden" name="id" value="<?= $livro['id'] ?>">
  <label>Título <input name="titulo" value="<?= e($livro['titulo']) ?>" required maxlength="150"></label>
  <label>Autor <input name="autor" value="<?= e($livro['autor']) ?>" required maxlength="100"></label>
  <label>Ano <input name="ano" type="number" value="<?= e($livro['ano']) ?>"></label>
  <label>Gênero <input name="genero" value="<?= e($livro['genero']) ?>" maxlength="50"></label>
  <label>Quantidade <input name="quantidade" type="number" min="1" value="<?= e($livro['quantidade']) ?>" required></label>
  <button>Salvar alterações</button>
</form>
<?php require 'rodape.php'; //Chama o rodape.php para a tela, ou seja, o rodapé do site.?>

