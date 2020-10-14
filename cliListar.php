<?php
require "funcoes.php";
$conexao = conecta();
header("Content-type: text/html; charset=utf-8");
$ordem = "ASC";
$campo = "cli_nome";
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
    function Excluir(inCPF){
        document.fexcluirCliente.cli_cpf.value = inCPF;
        document.fexcluirCliente.submit();
    }
	function Ordena(inCampo, inOrdem){
        document.flistarCliente.campo.value = inCampo;
        document.flistarCliente.ordem.value = inOrdem;		
        document.flistarCliente.submit();		
	}
    </script>
  </head>
  <body>
    <h2>Relatório de Cliente</h2>
    <form name="fexcluirCliente" action="cliExcluir.php" method="POST">
        <input type="hidden" name="cli_cpf">
    </form>
	<form name="flistarCliente" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<input type="hidden" name="ordem">
		<input type="hidden" name="campo">
	</form>
    <center>
    <input type="button" class="button" value="Novo Cliente" onClick="window.location.href='cliIncluir.php';" />
    </center>
    <br />
    <table width="100%" style="border: 1px solid gray; 
                               border-collapse: collapse;
                               margin: 0;">
      <tr>
        <th width="50px">Editar</th>
        <th>
			<b>CPF</b>&nbsp;
			<img src="img/baixo.png" onClick="Ordena('cli_cpf', 'DESC');" alt="Decrescente" title="Decrescente">
			<img src="img/cima.png" onClick="Ordena('cli_cpf', 'ASC');" alt="Crescente" title="Crescente">
		</th>
        <th>
			<b>Nome</b>
			<img src="img/baixo.png" onClick="Ordena('cli_nome', 'DESC');" alt="Decrescente" title="Decrescente">
			<img src="img/cima.png" onClick="Ordena('cli_nome', 'ASC');" alt="Crescente" title="Crescente">
		</th>
        <th><b>Endereço</b></th>
        <th><b>Complemento</b></th>
        <th><b>Bairro</b></th>
        <th><b>Cidade</b></th>
        <th><b>Estado</b></th>
        <th><b>Pais</b></th>
        <th><b>e-Mail</b></th>
      </tr>
    <?php
    $result = $conexao->query("SELECT cli_cpf, 
                                      cli_nome,
                                      cli_end_lograd,
                                      cli_end_compl,
                                      cli_end_bairro,
                                      cli_end_cidade,
                                      cli_end_uf,
                                      cli_end_pais,
                                      cli_login
                                      FROM cliente
									  ORDER BY ".$campo." ".$ordem);
    while ($linha = $result->fetch_assoc()) {
      echo "<tr>";
      echo "  <td style='text-align: center;'>
              <a href='cliAlterar.php?cpf=".$linha["cli_cpf"]."'><img src='img/lapis2.jpg' noborder height='20' title='Alterar'></a>    
              <a href='#' onclick='javascript:if(confirm(\"Excluir\\nConfirma a exclusão do Cliente CPF: ".formataCPF($linha["cli_cpf"])."?\"))Excluir(".$linha["cli_cpf"].")'>
              <img src='img/lixeira3.jpg' noborder height='20' title='Excluir'>
              </a>
              </td>";    
      echo "  <td>".formataCPF($linha["cli_cpf"])."</td>";
      echo "  <td>".$linha["cli_nome"]."</td>";
      echo "  <td>".$linha["cli_end_lograd"]."</td>";
      echo "  <td>".$linha["cli_end_compl"]."</td>";
      echo "  <td>".$linha["cli_end_bairro"]."</td>";
      echo "  <td>".$linha["cli_end_cidade"]."</td>";
      echo "  <td style='text-align: center;'>".$linha["cli_end_uf"]."</td>";
      echo "  <td>".$linha["cli_end_pais"]."</td>";
      echo "  <td>".$linha["cli_login"]."</td>";
      echo "</tr>";
    }
    $result->free();
    ?>
    </table>
  </body>
</html>