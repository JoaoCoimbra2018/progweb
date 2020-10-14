<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$venda_id       = "";
$venda_cli_cpf  = "";
$venda_data     = "";
$dia    = "";
$mes    = "";
$ano    = "";
$hora   = "";
$minuto = "";
//           111111
// 0123456789012345
// 01/01/2020 19:20
if (isset($_POST["venda_cli_cpf"])) {    
    $venda_cli_cpf = str_replace(".", "", str_replace("-", "", $_POST["venda_cli_cpf"]));
    $venda_data = $_POST["venda_data"];
    $dia     = substr($venda_data, 0, 2);
    $mes     = substr($venda_data, 3, 2);
    $ano     = substr($venda_data, 6, 4);
    $hora    = substr($venda_data, 11, 2);
    $minuto  = substr($venda_data, 14, 2);
    $venda_data = $ano."-".$mes."-".$dia." ".$hora.":".$minuto;
    if ($result = $conexao->query("INSERT INTO venda (venda_cli_cpf,
                                                      venda_data) 
                                   VALUES ('".$venda_cli_cpf."',
                                           '".$venda_data."')")) {;
    } else {
        echo "<script>alert('Erro na inclusão da Venda');</script>";
    }
    echo "<script>window.location.href='vendaListar.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Prog Web</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
    <script src="funcoes.js"></script>
    <script>
    function carregaDados(){
        // CPF
        var ele = document.getElementById("listaCliente");
        var cpf = ele.options[ele.selectedIndex].value;
        document.fvendaIncluir.venda_cli_cpf.value = formataCPF(cpf);
        // Data
        var data = new Date();
        var dia = data.getDate();
        if (parseInt(dia) < 10){
            dia = "0"+dia;
        }
        var mes = data.getMonth();
        mes = parseInt(mes) + 1;
        var ano = data.getFullYear();
        var hora = data.getHours();
        var minuto = data.getMinutes();
        if (parseInt(minuto) < 10) {
            minuto = "0"+minuto;
        }
        dataCompleta = dia+"/"+mes+"/"+ano+" "+hora+":"+minuto;
        document.getElementById("venda_data").value = dataCompleta;
    }
    function mostraCPF(){
        var ele = document.getElementById("listaCliente");
        var valor = ele.options[ele.selectedIndex].value;
        document.fvendaIncluir.venda_cli_cpf.value = formataCPF(valor);     
    }
    </script>
  </head>
  <body onload="carregaDados();">
    <h2>Nova Venda</h2>
    <form name="fvendaIncluir" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">  
      Cliente: <select name="listaCliente" id="listaCliente" onchange="mostraCPF();">
               <?php
                if ($result = $conexao->query("SELECT cli_cpf, 
                                                      cli_nome
                                               FROM cliente 
                                               ORDER BY cli_nome")) {
                    while ($linha = $result->fetch_assoc()) {
                      echo "<option value='".$linha["cli_cpf"]."'>".$linha["cli_nome"]."</option>\n";
                    }
                    $result->free();
                }              
               ?>
               </select>
      CPF: <input type="text" name="venda_cli_cpf" value="<?php echo $venda_cli_cpf; ?>" readonly>
      <br />
      <br />      
      Data da Venda: <input type="text" name="venda_data" id="venda_data" value="" style="font-family: Arial, Helvetica, sans-serif;" readonly>
      <center>
      <input type="submit" class="button" value="Salvar">
      <input type="button" class="button" value="Voltar" onClick="window.location.href='vendaListar.php';">
      </center>      
    </form>    
  </body>
</html>