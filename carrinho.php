<?php

session_start();

include("conexao.php");

$total = 0;

foreach($_SESSION['carrinho'] as $id => $qtd){

    $produto = $conn
    ->query("SELECT * FROM produtos WHERE id=$id")
    ->fetch_assoc();

    $subtotal = $produto['preco'] * $qtd;

    $total += $subtotal;

    echo $produto['nome'];
    echo "<br>";

    echo "Qtd: ".$qtd;
    echo "<br>";

    echo "Subtotal: R$".$subtotal;
    echo "<hr>";
}

echo "<h2>Total: R$ $total</h2>";