<?php
require "funcoes.php";
$conexao = conecta();
$prod_id    = "";
$prod_preco = "";
$prod_quant = "";
if (isset($_GET["id"])){
    $prod_id = $_GET["id"];
    $result = $conexao->query("SELECT prod_preco, prod_quant FROM produto WHERE prod_id = ".$prod_id);
    if ($linha = $result->fetch_assoc()){
        $prod_preco = str_replace(".", ",", $linha["prod_preco"]);
        $prod_quant = str_replace(",", ".", $linha["prod_quant"]);
    }
    echo $prod_preco."/".$prod_quant;
}
?>