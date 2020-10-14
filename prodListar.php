<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
header("Content-type: text/html; charset=utf-8");
$ordem = "ASC";
$campo = "prod_desc";
if (isset($_POST["campo"])) {
    $ordem = $_POST["ordem"];
    $campo = $_POST["campo"];
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
    function Excluir(inId){
        document.fexcluirProduto.prod_id.value = inId;
        document.fexcluirProduto.submit();
    }
    function Ordena(inCampo, inOrdem){
        document.flistarProduto.campo.value = inCampo;
        document.flistarProduto.ordem.value = inOrdem;
        document.flistarProduto.submit();
    }   
    </script>
  </head>
  <body>
    <h2>Relatório de Produto</h2>
    <form name="fexcluirProduto" action="prodExcluir.php" method="POST">
        <input type="hidden" name="prod_id">
    </form>
    <form name="flistarProduto" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="ordem">
        <input type="hidden" name="campo">
    </form> 
    <center>
    <input type="button" class="button" value="Novo Produto" onClick="window.location.href='prodIncluir.php';" />
    </center>
    <br />
    <table width="100%" style="border: 1px solid gray; border-collapse: collapse;">
      <tr>
        <th width="50px">Editar</th>
        <th>
            <b>Descrição</b>
            <img src="img/baixo.png" onClick="Ordena('prod_desc', 'DESC');" alt="Decrescente" title="Decrescente">
            <img src="img/cima.png" onClick="Ordena('prod_desc', 'ASC');" alt="Crescente" title="Crescente">
        </th>
        <th><b>Preço</b></th>
        <th><b>Estoque</b></th>
      </tr>
    <?php
    if ($result = $conexao->query("SELECT prod_id, 
                                          prod_desc,
                                          prod_preco,
                                          prod_quant
                                          FROM Produto
                                   ORDER BY ".$campo." ".$ordem)) {
        while ($linha = $result->fetch_assoc()) {
          echo "<tr>";
          echo "  <td style='text-align: center;'>
                  <a href='prodAlterar.php?id=".$linha["prod_id"]."'><img src='img/lapis2.jpg' noborder height='20' title='Alterar'></a>
                <a href='#' onclick='javascript:if(confirm(\"Excluir\\nConfirma a exclusão do Produto: ".$linha["prod_desc"]."?\"))Excluir(".$linha["prod_id"].");'>
                  <img src='img/lixeira3.jpg' noborder height='20' title='Excluir'>
                  </a>
                  </td>";    
          echo "  <td>".$linha["prod_desc"]."</td>";
          echo "  <td style='text-align: right;'>".number_format($linha["prod_preco"], 2, ",", ".")."</td>";
          echo "  <td style='text-align: right;'>".number_format($linha["prod_quant"],0, ",", ".")."</td>";
          echo "</tr>";
        }
        $result->free();
    }
    ?>
    </table>
  </body>
</html>