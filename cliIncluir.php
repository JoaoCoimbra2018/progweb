<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require "funcoes.php";
$conexao = conecta();
// Variáveis dos campos do formulário
$cli_cpf        = "";
$cli_nome       = "";
$cli_end_lograd = "";
$cli_end_compl  = "";
$cli_end_bairro = "";
$cli_end_cidade = "";
$cli_end_uf     = "";
$cli_end_pais   = "";
$cli_email      = ""; // login e-mail
$cli_senha      = "";
$cli_senha_repetida      = "";
if (isset($_POST["cli_cpf"])) {
    $cli_cpf        = $_POST["cli_cpf"];        
    $cli_nome       = $_POST["cli_nome"];
    $cli_end_lograd = $_POST["cli_end_lograd"];
    $cli_end_compl  = $_POST["cli_end_compl"];
    $cli_end_bairro = $_POST["cli_end_bairro"];
    $cli_end_cidade = $_POST["cli_end_cidade"];
    $cli_end_uf     = $_POST["cli_end_uf"];
    $cli_end_pais   = $_POST["cli_end_pais"];
    $cli_email      = $_POST["cli_email"];
    $cli_senha      = md5($_POST["cli_senha"]);    
    if (achaCliente($cli_cpf))    {
        echo "<script>alert('Cliente já existe');</script>";
    } else {
        if ($result = $conexao->query("INSERT INTO cliente (cli_cpf,
                                                              cli_nome,
                                                              cli_end_lograd,
                                                              cli_end_compl,
                                                              cli_end_bairro,
                                                              cli_end_cidade,
                                                              cli_end_uf,
                                                              cli_end_pais,
                                                              cli_login,
                                                              cli_senha) 
                                                           VALUES ('".$cli_cpf."',
                                                              '".$cli_nome."',
                                                              '".$cli_end_lograd."',
                                                              '".$cli_end_compl."',
                                                              '".$cli_end_bairro."',
                                                              '".$cli_end_cidade."',
                                                              '".$cli_end_uf."',
                                                              '".$cli_end_pais."',
                                                              '".$cli_email."',
                                                              '".$cli_senha."')")){;
            mysqli_free_result($result);
        } else {
            echo "<script>alert('Erro na inclusão do Cliente');</script>";
        }
    }
	echo "<script>window.location.href='cliListar.php';</script>";
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
    function Valida(){
        var conf = true;
        var msg = "";
        with (document.fcliIncluir){
            // Valida tudo e submit
            conf = confereCPF(cli_cpf.value);
            if ((conf == true) && (cli_nome.value === "")) {
                msg = "Nome necessita ser informado";
                conf = false;
            }
            if ((conf == true) && (!confereSenhas(cli_senha.value, cli_senha_repetida.value))) {
                cli_senha.value = "";
                cli_senha_repetida.value = "";
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
    <h2>Novo Cliente</h2>
    <form name="fcliIncluir" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      CPF (somente números): <input type="text" name="cli_cpf" size="15" maxlength="11" placeholder="Qual seu CPF?" 
                              required>
      &nbsp;Nome: <input type="text" name="cli_nome" size="100" maxlength="100" placeholder="Qual seu nome?" 
                   required>
      <br/>
      <br/>
      Endereço: <input type="text" name="cli_end_lograd" size="100" maxlength="200" placeholder="Qual seu endereço?" 
                 required>
      &nbsp;Complemento: <input type="text" name="cli_end_compl" placeholder="Qual seu complemento?">
      Bairro: <input type="text" name="cli_end_bairro" placeholder="Qual seu bairro?" required>
      <br/>
      <br/>
      Estado: <select name="cli_end_uf" id="cli_end_uf">
                <option value="AC">AC</option>
                <option value="AL">AL</option>
                <option value="AP">AP</option>
                <option value="AM">AM</option>
                <option value="BA">BA</option>
                <option value="CE">CE</option>
                <option value="DF">DF</option>
                <option value="ES">ES</option>
                <option value="GO">GO</option>
                <option value="MA">MA</option>
                <option value="MT">MT</option>
                <option value="MS">MS</option>
                <option value="MG">MG</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PR">PR</option>
                <option value="PE">PE</option>
                <option value="PI">PI</option>
                <option value="RJ" selected>RJ</option>
                <option value="RN">RN</option>
                <option value="RS">RS</option>
                <option value="RO">RO</option>
                <option value="RR">RR</option>
                <option value="SC">SC</option>
                <option value="SP">SP</option>
                <option value="SE">SE</option>
                <option value="TO">TO</option>
            </select>      
      Cidade: <input type="text" name="cli_end_cidade" placeholder="Qual sua cidade?" required>
      País: <input type="text" name="cli_end_pais" placeholder="Qual o seu pais?" required>
      <br/>
      <br/>
      e-Mail: <input type="email" name="cli_email" placeholder="Qual o seu e-mail?" required>
      Senha: <input type="password" name="cli_senha" placeholder="Qual a sua senha?" required>
      Repetir a Senha: <input type="password" name="cli_senha_repetida" placeholder="Repita a sua senha?" required>
      <br/>
      <center>
      <input type="button" class="button" value="Salvar" onClick="Valida();">
      <input type="button" class="button" value="Voltar" onClick="window.location.href='cliListar.php';">
      </center>      
    </form>    
  </body>
</html>