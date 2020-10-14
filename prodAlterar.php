<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$prod_id    = "";
$prod_desc  = "";
$prod_preco = "";
$prod_quant = "";
if (isset($_GET["id"])){
    $prod_id = $_GET["id"];
    if ($result = $conexao->query("SELECT * FROM produto WHERE prod_id = '".$prod_id."'")) {
        if ($linha = $result->fetch_assoc()){
            $prod_desc = $linha["prod_desc"];
            $prod_preco = str_replace(".", ",", $linha["prod_preco"]);
            $prod_quant = $linha["prod_quant"]; 
        } else {
            echo "<script>alert('Erro no acesso aos dados');</script>";
        }
        mysqli_free_result($result);
    } else {
        echo "<script>alert('Erro no acesso aos dados');</script>";
        
    }
}
if (isset($_POST["prod_id"])) { 
    $prod_id    = $_POST["prod_id"];
    $prod_desc  = $_POST["prod_desc"];
    $prod_preco = $_POST["prod_preco"];
    $prod_quant = $_POST["prod_quant"]; 
    if ($result = $conexao->query("UPDATE produto 
                                   SET  prod_desc  = '".$prod_desc."',
                                        prod_preco =  ".str_replace(",", ".", $prod_preco).",
                                        prod_quant =  ".$prod_quant."
                                    WHERE prod_id  =  ".$prod_id)){;
    } else {
        echo "<script>alert('Erro na alteração do Produto');</script>";
    }
    echo "<script>window.location.href='prodListar.php';</script>";
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
    function restrictMoney(e) {
     var x = e.which || e.keycode;
     var string = String.fromCharCode(x);
     if ((x >= 48 && x <= 57) || (string == "," || string == "."))
         return true;
     else
         return false;
    }
    function restrictAlphabets(e) {
     var x = e.which || e.keycode;
     if ((x >= 48 && x <= 57))
         return true;
     else
         return false;
    }
    function umaVirgula(inTexto){
        var conta = 0;
        for (i = 0; i < inTexto.length; i++){
            if (inTexto.charAt(i) == ",") {
                conta = parseInt(conta) + 1;
            }
        }
        if ((parseInt(conta) == 0) || (parseInt(conta)) == 1){
            return true;
        } else {
            return false;
        }
    }
    function Valida(){
        var conf = true;
        var msg = "";
        with (document.fprodAlterar){
           if (prod_desc.value === "") {
                msg = "Descrição necessita ser informada";
                conf = false;
            }
            if ((conf == true) && (parseFloat(prod_preco.value) <= 0)){
                msg = "Preço necessita ser maior que zero";
                conf = false;
            }
            if ((conf == true) && (!umaVirgula(prod_preco.value))) {
                msg = "Preço incorreto";
                conf = false;
            }           
            if (conf == true) {
                submit();
            } else {
                Alerta("Erro", msg);
            }            
        }  // Fim with (document.fCliente){
    }    
    </script>
  </head>
  <body>
    <h2>Alterar Produto</h2>
    <form name="fprodAlterar" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <input type="hidden" name="prod_id" value="<?php echo $prod_id ?>">
      Descrição: <textarea name="prod_desc" rows="4" cols="50" placeholder="Qual a descrição do produto?" 
                  required><?php echo $prod_desc ?></textarea>
      <br />
      <br />      
      Preço: <input type="text" name="prod_preco" size="30" maxlength="20" placeholder="Qual o preço?" onpaste="return false"
              style="text-align: right;" required value="<?php echo $prod_preco ?>" onkeypress="return restrictMoney(event)">
      <br />
      <br />      
      Estoque: <input type="text" name="prod_quant" size="20" maxlength="20" onpaste="return false" style="text-align: right;" placeholder="Qual o estoque?" required  value="<?php echo $prod_quant ?>" onkeypress="return restrictAlphabets(event)">
      <center>
      <input type="button" class="button" value="Salvar" onClick="Valida();">
      <input type="button" class="button" value="Voltar" onClick="window.location.href='prodListar.php';">
      </center>      
    </form>    
  </body>
</html>