<?php
session_start();
require "funcoes.php";
$conexao = conecta();
header("Content-type: text/html; charset=utf-8");
$ordem = "ASC";
$campo = "nome";
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
    function Excluir(inID){
        document.fexcluirVenda.venda_id.value = inID;
        document.fexcluirVenda.submit();
    }
    function Ordena(inCampo, inOrdem){
        document.flistarVenda.campo.value = inCampo;
        document.flistarVenda.ordem.value = inOrdem;
        document.flistarVenda.submit();
    }   
    </script>
  </head>
  <body>
    <h2>Relatório de Venda</h2>
    <form name="fexcluirVenda" action="vendaExcluir.php" method="POST">
        <input type="hidden" name="venda_id">
    </form>
    <form name="flistarVenda" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="ordem">
        <input type="hidden" name="campo">
    </form> 
    <center>
    <input type="button" class="button" value="Nova Venda" onClick="window.location.href='vendaIncluir.php';" />
    </center>
    <br />
    <table width="100%" style="border: 1px solid gray; 
                               border-collapse: collapse;
                               margin: 0;">
      <tr>
        <th width="4%">Editar</th>
        <th width="7%">
            <b>Venda</b>
            <img src="img/baixo.png" onClick="Ordena('venda_id', 'DESC');" alt="Decrescente" title="Decrescente">
            <img src="img/cima.png" onClick="Ordena('venda_id', 'ASC');" alt="Crescente" title="Crescente">         
        </th>       
        <th>
            <b>CPF</b>
            <img src="img/baixo.png" onClick="Ordena('cpf', 'DESC');" alt="Decrescente" title="Decrescente">
            <img src="img/cima.png" onClick="Ordena('cpf', 'ASC');" alt="Crescente" title="Crescente">         
        </th>
        <th>
            <b>Cliente</b>
            <img src="img/baixo.png" onClick="Ordena('nome', 'DESC');" alt="Decrescente" title="Decrescente">
            <img src="img/cima.png" onClick="Ordena('nome', 'ASC');" alt="Crescente" title="Crescente">         
        </th>
        <th>
            <b>Data</b>
            <img src="img/baixo.png" onClick="Ordena('data', 'DESC');" alt="Decrescente" title="Decrescente">
            <img src="img/cima.png" onClick="Ordena('data', 'ASC');" alt="Crescente" title="Crescente">
        </th>
      </tr>
    <?php
    if ($result = $conexao->query("SELECT venda_id,
                                          c.cli_cpf as cpf, 
                                          c.cli_nome as nome,
                                          v.venda_data as data
                                          FROM venda v LEFT JOIN cliente c ON v.venda_cli_cpf = c.cli_cpf
                                          ORDER BY ".$campo." ".$ordem)) {
        while ($linha = $result->fetch_assoc()) {
          $data = strtotime($linha["data"]);
          $data = date("d/m/Y H:i", $data);         
          echo "<tr>";
          echo "  <td style='text-align: center;'>
                  <a href='itemListar.php?id=".$linha["venda_id"]."'><img src='img/lapis2.jpg' noborder height='20' title='Ítens da Venda'></a>&nbsp;    
                  <a href='#' onclick='javascript:if(confirm(\"Excluir\\nConfirma a exclusão da Venda CPF: ".formataCPF($linha["cpf"])." Data: ".$data."?\"))Excluir(".$linha["venda_id"].")'>
                  <img src='img/lixeira3.jpg' noborder height='20' title='Excluir'>
                  </a>
                  </td>";   
          echo "  <td style='text-align: center;'>".$linha["venda_id"]."</td>";               
          echo "  <td>".formataCPF($linha["cpf"])."</td>";
          echo "  <td>".$linha["nome"]."</td>";
          echo "  <td>".$data."</td>";
          echo "</tr>";
        }
        $result->free();
    }
    ?>
    </table>
  </body>
</html>