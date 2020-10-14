<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$item_quant = "";
$item_preco = "";
$item_prod_id = "";
$item_venda_id = "";
if (isset($_GET["id"])){
    $item_venda_id = $_GET["id"];
}
if (isset($_POST["item_quant"])) {
    $item_quant     = $_POST["item_quant"];
    $item_preco     = $_POST["item_preco"];
    $item_prod_id   = $_POST["item_prod_id"];
    $item_venda_id  = $_POST["item_venda_id"];
    if (achaItem($item_venda_id, $item_prod_id))    {
        echo "<script>alert('Item já existe');</script>";
    } else {
       if ($result = $conexao->query("INSERT INTO item (item_quant,
                                                        item_preco,
                                                        item_prod_id,
                                                        item_venda_id) 
                                       VALUES (".$item_quant.",
                                               ".str_replace(",", ".", $item_preco).",
                                               ".$item_prod_id.",
                                               ".$item_venda_id.")")) {;
        } else {
            echo "<script>alert('Erro na inclusão do Item');</script>";
        }
    }
    echo "<script>window.location.href='itemListar.php?id=".$item_venda_id."';</script>";
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
    function mostraProduto(){
        var ele = document.getElementById("listaProduto");
        var prod_id = ele.options[ele.selectedIndex].value;
        var retorno = "";
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                retorno = this.responseText;
                var vetor = retorno.split("/");
                document.fitemIncluir.item_preco.value = vetor[0];
                document.fitemIncluir.prod_quant.value = vetor[1];
            }
        };
        xhttp.open("GET", "prodProduto.php?id="+prod_id, true);
        xhttp.send();
    }   
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
        with (document.fitemIncluir){
            // Valida tudo e submit
            if (!Number.isInteger(parseInt(item_quant.value))) {
            //if (item_quant.value == "" || item_quant.value == null || parseInt(item_quant.value) <= 0) {
                msg = "Quantidade necessita ser informada";
                conf = false;
            }
            if ((conf == true) && (parseInt(item_quant.value) > parseInt(prod_quant.value))) {
                msg = "Quantidade maior que o Estoque";
                conf = false;
            }
            if (conf == true) {
                var ele = document.getElementById("listaProduto");
                item_prod_id.value = ele.options[ele.selectedIndex].value;
                submit();
            } else {
                Alerta("Erro", msg);
            }
        }  // Fim with (document.fitemIncluir){
    }    
    </script>
  </head>
  <body onload="mostraProduto();">
    <h2>Novo Item da Venda: <?php echo $item_venda_id; ?></h2>
    <form name="fitemIncluir" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <input type="hidden" name="item_prod_id" value="<?php echo $item_prod_id; ?>">
      <input type="hidden" name="item_venda_id" value="<?php echo $item_venda_id; ?>">
      Quantidade: <input type="text" name="item_quant" size="20" maxlength="20" onpaste="return false" 
                   style="text-align: right;" placeholder="Qual a quantidade?" required  
                   onkeypress="return restrictAlphabets(event)">             
      <br />
      <br />
      Produto <select name="listaProduto" id="listaProduto" onchange="mostraProduto()">
               <?php
                if ($result = $conexao->query("SELECT prod_id,
                                                      prod_desc, 
                                                      prod_quant,
                                                      prod_preco
                                               FROM produto 
                                               ORDER BY prod_desc")) {
                    while ($linha = $result->fetch_assoc()) {
                      echo "<option value='".$linha["prod_id"]."'>".$linha["prod_desc"]."</option>\n";
                    }
                    $result->free();
                }              
               ?>
               </select>
        Preço: <input type="text" name="item_preco" id="item_preco" value="" readonly>
        Estoque: <input type="text" name="prod_quant" id="prod_quant" value="" readonly>
      <br />
      <br />
      <center>
      <input type="button" class="button" value="Salvar" onClick="Valida();">
      <input type="button" class="button" value="Voltar" 
       onClick="window.location.href='itemListar.php?id=<?php echo $item_venda_id; ?>';">
      </center>
    </form>
  </body>
</html>