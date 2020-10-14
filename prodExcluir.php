<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$prod_id = "";
if (isset($_POST["prod_id"])){
    $prod_id = $_POST["prod_id"];
    if ($result = $conexao->query("DELETE FROM produto WHERE prod_id = ".$prod_id)){
        mysqli_free_result($result);
    } else {
        echo "<script>alert('Erro na exclusão do Produto');</script>";
    }
echo "<script>window.location.href='prodListar.php';</script>";    
}
?>
