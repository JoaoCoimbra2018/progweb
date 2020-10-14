<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$item_id = "";
if (isset($_POST["item_id"])){
    $item_id = $_POST["item_id"];
    $item_venda_id = $_POST["item_venda_id"];
    if ($result = $conexao->query("DELETE FROM item WHERE item_id = ".$item_id)){
        mysqli_free_result($result);
    } else {
        echo "<script>alert('Erro na exclusão do Item');</script>";
    }
    echo "<script>window.location.href='itemListar.php?id=".$item_venda_id."';</script>";    
}
?>
