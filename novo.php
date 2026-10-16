<?php
//Resumidamente, este código todo só serve CASO FOR NECESSÁRIO cadastrar um livro novo.
require 'conexao.php'; //Primeiro de tudo, ele SEMPRE necessita que conexão esteja presente.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {          //Indica que o formulário entrou em processo.
    $sql = "INSERT INTO livros (titulo, autor, ano, genero, quantidade)
            VALUES (:titulo, :autor, :ano, :genero, :quantidade)";
            //SQL funciona atualizando os valores presentes dos livros.
    $consulta = $pdo->prepare($sql); //Consulta o PDO, e então o prepara para em seguida executar a consulta com segurança.
    $consulta->execute([
        ':titulo'     => $_POST['titulo'],
        ':autor'      => $_POST['autor'],
        ':ano'        => $_POST['ano'] !== '' ? (int)$_POST['ano'] : null,
        ':genero'     => $_POST['genero'],
        ':quantidade' => (int)$_POST['quantidade'],
    ]);
    header('Location: index.php?msg=' . urlencode('Livro cadastrado!'));  //Após cadastrado, ele salva e retorna para a lista.
    exit;
}

require 'topo.php'; //Como sempre, chama topo.php (cabeçário) para a lista, desta vez amostrando o livro novo presente.
?>
<h2>Novo livro</h2>
<form method="post" class="ficha">
  <label>Título <input name="titulo" required maxlength="150"></label>
  <label>Autor <input name="autor" required maxlength="100"></label>
  <label>Ano <input name="ano" type="number"></label>
  <label>Gênero <input name="genero" maxlength="50"></label>
  <label>Quantidade <input name="quantidade" type="number" min="1" value="1" required></label>
  <button>Salvar</button>
</form>
<?php require 'rodape.php'; // Rodapé do site. ?>
