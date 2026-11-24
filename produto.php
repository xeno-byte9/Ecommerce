<?php

include("conexao.php");

$id = $_GET['id'];

$sql = "SELECT * FROM produtos WHERE id=$id";
$resultado = $conn->query($sql);

$produto = $resultado->fetch_assoc();
?>

<h1><?= $produto['nome'] ?></h1>

<img src="<?= $produto['imagem'] ?>" width="300">

<p><?= $produto['descricao'] ?></p>

<h3>R$ <?= $produto['preco'] ?></h3>

<p>
Estoque:
<?= $produto['estoque'] > 0 ? "Disponível" : "Indisponível" ?>
</p>

<form action="adicionar_carrinho.php" method="post">
    <input
        type="hidden"
        name="produto_id"
        value="<?= $produto['id'] ?>"
    >

    <button>Adicionar ao Carrinho</button>
</form>
