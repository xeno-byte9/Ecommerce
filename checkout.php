<?php

session_start();
include("conexao.php");

if(!isset($_SESSION['usuario'])){
    die("Faça login.");
}

$usuario_id = $_SESSION['usuario'];
$forma = $_POST['pagamento'];

$total = 0;

foreach($_SESSION['carrinho'] as $id => $qtd){

    $produto = $conn
        ->query("SELECT * FROM produtos WHERE id=$id")
        ->fetch_assoc();

    $total += $produto['preco'] * $qtd;
}

$conn->query("
INSERT INTO pedidos
(usuario_id, valor_total, pagamento)
VALUES
($usuario_id, $total, '$forma')
");

$pedido_id = $conn->insert_id;

foreach($_SESSION['carrinho'] as $id => $qtd){

    $produto = $conn
        ->query("SELECT * FROM produtos WHERE id=$id")
        ->fetch_assoc();

    if($qtd > $produto['estoque']){
        die("Estoque insuficiente");
    }

    $preco = $produto['preco'];

    $conn->query("
    INSERT INTO pedido_itens
    (
        pedido_id,
        produto_id,
        quantidade,
        preco_unitario
    )
    VALUES
    (
        $pedido_id,
        $id,
        $qtd,
        $preco
    )
    ");

    $conn->query("
    UPDATE produtos
    SET estoque = estoque - $qtd
    WHERE id = $id
    ");
}

unset($_SESSION['carrinho']);

echo "Pedido realizado com sucesso!";