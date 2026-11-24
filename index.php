<?php
include("conexao.php");

$busca = $_GET['busca'] ?? '';

$sql = "
SELECT *
FROM produtos
WHERE ativo = 1
AND nome LIKE '%$busca%'
";

$resultado = $conn->query($sql);

while($produto = $resultado->fetch_assoc()){
?>
    <div>
        <img src="<?= $produto['imagem'] ?>" width="200">
        <h3><?= $produto['nome'] ?></h3>
        <p>R$ <?= $produto['preco'] ?></p>

        <a href="produto.php?id=<?= $produto['id'] ?>">
            Ver detalhes
        </a>
    </div>
<?php
}
?>

