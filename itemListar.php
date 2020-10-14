<?php
session_start();
require "funcoes.php";
$conexao = conecta();
header("Content-type: text/html; charset=utf-8");
$item_id  = "";
$item_quant = "";
$item_preco  = "";
$item_prod_id = "";
$item_venda_id = "";
$total_vend = "";
$ordem = "ASC";
$campo = "produto";
if (isset($_SESSION["campo"])) {
    $ordem = $_SESSION["ordem"];
    $campo = $_SESSION["campo"];    
}
if (isset($_POST["campo"])) {
    $ordem = $_POST["ordem"];
    $campo = $_POST["campo"];
    $_SESSION["ordem"] = $ordem;
    $_SESSION["campo"] = $campo;    
}
if (isset($_GET["id"])) {
    $item_venda_id = $_GET["id"];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Prog Web</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
    <style>
        td {background-color: rgba(255,255,255,1);}
    </style>
    <script>
    function Excluir(inID, inVendaID){
        document.fexcluirItem.item_id.value = inID;
        document.fexcluirItem.item_venda_id.value = inVendaID;
        document.fexcluirItem.submit();
    }
    function Ordena(inCampo, inOrdem){
        document.flistarItem.campo.value = inCampo;
        document.flistarItem.ordem.value = inOrdem;
        document.flistarItem.submit();
    }   
    </script>
  </head>
  <body>
    <h2>Relatório de Itens da Venda: <?php echo $item_venda_id; ?></h2>
    <form name="fexcluirItem" action="itemExcluir.php" method="POST">
        <input type="hidden" name="item_id">
        <input type="hidden" name="item_venda_id">
    </form>
    <form name="flistarItem" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="ordem">
        <input type="hidden" name="campo">
    </form> 
    <center>
    <input type="button" class="button" value="Novo Item" 
     onClick="window.location.href='itemIncluir.php?id=<?php echo $item_venda_id; ?>';" />
    </center>
    <br />
    <table width="100%" style="border: 1px solid gray; 
                               border-collapse: collapse;
                               margin: 0;">
      <tr>
        <th width="5%">Editar</th>
        <th width="60%">
            <b>Produto</b>
            <img src="img/baixo.png" onClick="Ordena('produto', 'DESC');" alt="Decrescente" title="Decrescente">
            <img src="img/cima.png" onClick="Ordena('produto', 'ASC');" alt="Crescente" title="Crescente">         
        </th>
        <th width="10%">
            <b>Quantidade</b>
            <img src="img/baixo.png" onClick="Ordena('item_quant', 'DESC');" alt="Decrescente" title="Decrescente">
            <img src="img/cima.png" onClick="Ordena('item_quant', 'ASC');" alt="Crescente" title="Crescente">         
        </th>
        <th width="10%">
            <b>Preço</b>
            <img src="img/baixo.png" onClick="Ordena('item_preco', 'DESC');" alt="Decrescente" title="Decrescente">
            <img src="img/cima.png" onClick="Ordena('item_preco', 'ASC');" alt="Crescente" title="Crescente">
        </th>
       <th width="15%"><b>Total</b></th>        
      </tr>
    <?php
    $total_venda = 0;
    if ($result = $conexao->query("SELECT item_id,
                                          item_quant,
                                          item_preco,
                                          item_venda_id,
                                          item_prod_id,
                                          p.prod_desc as produto,
                                          item_quant * item_preco as total
                                  FROM item i LEFT JOIN produto p ON i.item_prod_id = p.prod_id
                                  WHERE item_venda_id = ".$item_venda_id."
                                  ORDER BY ".$campo." ".$ordem)) {
        while ($linha = $result->fetch_assoc()) {   
          echo "<tr>";
          echo "  <td style='text-align: center;'>
                  <a href='itemAlterar.php?id=".$linha["item_id"]."'><img src='img/lapis2.jpg' noborder height='20' title='Alterar'></a>&nbsp;    
                  <a href='#' onclick='javascript:if(confirm(\"Excluir\\nConfirma a exclusão do Item: ".$linha["produto"]."?\"))Excluir(".$linha["item_id"].",".$item_venda_id.")'>
                  <img src='img/lixeira3.jpg' noborder height='20' title='Excluir'>
                  </a>
                  </td>";   
          echo "  <td>".$linha["produto"]."</td>";
          echo "  <td style='text-align: right;'>".$linha["item_quant"]."</td>";
          echo "  <td style='text-align: right;'>".str_replace(".", ",", $linha["item_preco"])."</td>";       
          echo "  <td style='text-align: right;'>".number_format($linha["total"], 2, ",", ".")."</td>";
          echo "</tr>";
          $total_venda += $linha["total"];
        }
        $result->free();
        echo "<tr>";
        echo "<td colspan='4' style='text-align: right;'>Total da Venda&nbsp;</td>";
        echo "<td style='text-align: right;'>".number_format($total_venda, 2, ",", ".")."</td>";        
        echo "</tr>";
    }
    ?>
    </table>
  </body>
</html>