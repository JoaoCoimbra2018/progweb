<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$cli_cpf = "";
if (isset($_POST["cli_cpf"])){
    $cli_cpf = $_POST["cli_cpf"];
    if ($result = $conexao->query("DELETE FROM cliente WHERE cli_cpf = '".$cli_cpf."'")){;
        mysqli_free_result($result);            
    } else {
        echo "<script>alert('Erro na exclusão do Cliente');</script>";
    }
    echo "<script>window.location.href='cliListar.php';</script>";    
}    
?>
