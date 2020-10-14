<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$item_id       = "";
$item_quant    = "";
$item_preco    = "";
$item_venda_id = "";
$prod_desc     = "";
if (isset($_GET["id"])){
    if (is_numeric($_GET["id"])) {
        $item_id = trim(htmlentities($_GET["id"]));
        $item_id = $conexao->real_escape_string($item_id);
        if ($result = $conexao->query("SELECT * FROM item i LEFT JOIN produto p ON i.item_prod_id = p.prod_id 
                                       WHERE item_id = '".$item_id."'")) {
            if ($linha = $result->fetch_assoc()){
                $item_quant = $linha["item_quant"];
                $item_preco = str_replace(".", ",", $linha["item_preco"]);
                $item_venda_id = $linha["item_venda_id"];
                $prod_desc = $linha["prod_desc"];
            } else {
                echo "<script>alert('Erro no acesso aos dados');</script>";
            }
            mysqli_free_result($result);
        } else {
            echo "<script>alert('Erro no acesso aos dados');</script>";
        }
    }
}
if (isset($_POST["item_id"])) { 
    $item_id    = $_POST["item_id"];
    $item_quant  = $_POST["item_quant"];
    $item_preco = $_POST["item_preco"];
    $item_venda_id = $_POST["item_venda_id"];
    if ($result = $conexao->query("UPDATE item 
                                   SET  item_quant  = ".$item_quant.",
                                        item_preco =  ".str_replace(",", ".", $item_preco)."
                                    WHERE item_id  =  ".$item_id)){;
    } else {
        echo "<script>alert('Erro na alteração do Item');</script>";
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
            if (inTexto.charAt(i) == ","){
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
        with (document.fitemAlterar){
            if (!Number.isInteger(parseInt(item_quant.value))) {
                msg = "Quantidade incorreta ou inexistente";
                conf = false;
            }
            if ((conf == true) && (parseFloat(item_preco.value) <= 0)){
                msg = "Preço necessita ser maior que zero";
                conf = false;
            }
            if ((conf == true) && (!umaVirgula(item_preco.value))) {
                msg = "Preço incorreto";
                conf = false;
            }
            if (conf == true){
                submit();
            } else {
                Alerta("Erro", msg);
            }
        }  // Fim with (document.fCliente){
    }    
    </script>
  </head>
  <body>
    <h2>Alterar Item: <?php echo $item_id." Descrição: ".$prod_desc ?> <br />Venda: <?php echo $item_venda_id; ?></h2>
    <form name="fitemAlterar" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <input type="hidden" name="item_id" value="<?php echo $item_id ?>">
      <input type="hidden" name="item_venda_id" value="<?php echo $item_venda_id ?>">
      Quantidade: <input type="text" name="item_quant" value="<?php echo $item_quant; ?>" size="20" maxlength="20" 
                   onpaste="return false" 
                   style="text-align: right;" placeholder="Qual a quantidade?" required  
                   onkeypress="return restrictAlphabets(event)">
      <br />
      <br />
      Preço: <input type="text" name="item_preco" value="<?php echo $item_preco; ?>" size="30" maxlength="20" 
              placeholder="Qual o preço?" onpaste="return false"
              style="text-align: right;" required onkeypress="return restrictMoney(event)">
      <br />
      <center>
      <input type="button" class="button" value="Salvar" onClick="Valida();">
      <input type="button" class="button" value="Voltar"
       onClick="window.location.href='itemListar.php?id=<?php echo $item_venda_id; ?>';">
      </center>
    </form>
  </body>
</html>