<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$venda_id = "";
if (isset($_POST["venda_id"])){
    $venda_id = $_POST["venda_id"];
    if ($result = $conexao->query("DELETE FROM venda WHERE venda_id = ".$venda_id)){;
        mysqli_free_result($result);            
    } else {
        echo "<script>alert('Erro na exclusão da Venda');</script>";
    }
    echo "<script>window.location.href='vendaListar.php';</script>";    
}    
?>
