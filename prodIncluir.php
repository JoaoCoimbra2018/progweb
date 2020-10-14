<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$prod_desc  = "";
$prod_preco = "";
$prod_quant = "";
if (isset($_POST["prod_desc"])) {
    $prod_desc      = $_POST["prod_desc"];
    $prod_preco     = $_POST["prod_preco"];
    $prod_quant     = $_POST["prod_quant"];
    if (achaProduto($prod_desc))    {
        echo "<script>alert('Produto já existe');</script>";
    } else {
       if ($result = $conexao->query("INSERT INTO produto (prod_desc,
                                                            prod_preco,
                                                            prod_quant) 
                                       VALUES ('".$prod_desc."',
                                                ".str_replace(",", ".", $prod_preco).",
                                                ".$prod_quant.")")){;
        } else {
            echo "<script>alert('Erro na inclusão do Produto');</script>";
        }
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
    <style>
        textarea {vertical-align: top;}
        .numero {text-align: right;}
    </style>
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
        with (document.fprodIncluir){
            // Valida tudo e submit
            if (prod_desc.value === "") {
                msg = "Descrição necessita ser informada";
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
    <h2>Novo Produto</h2>
    <form name="fprodIncluir" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      Descrição: <textarea name="prod_desc" rows="4" cols="50" placeholder="Qual a descrição do produto?" 
                  required></textarea>
      <br />
      <br />
      Preço: <input type="text" name="prod_preco" size="30" maxlength="20" placeholder="Qual o preço?" onpaste="return false"
              style="text-align: right;" required onkeypress="return restrictMoney(event)">
      <br />
      <br />
      Estoque: <input type="text" name="prod_quant" size="20" maxlength="20" onpaste="return false" style="text-align: right;"          placeholder="Qual o estoque?" required  onkeypress="return restrictAlphabets(event)">
      <center>
      <input type="button" class="button" value="Salvar" onClick="Valida();">
      <input type="button" class="button" value="Voltar" onClick="window.location.href='prodListar.php';">
      </center>
    </form>
  </body>
</html>