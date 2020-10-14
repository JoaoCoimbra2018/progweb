<?php
function conecta(){
    $conexao = new mysqli("127.0.0.1", "root", "", "progweb");
    if ($conexao->connect_errno) {
        die("Falha na conexaoexão com o Banco de Dados: " . $conexao->connect_error);
        exit();
    } else {
        //echo "<script>alert('Conexão com o BD bem sucedida');</script>";
        return $conexao;
    }
}    
function formataCPF($inCPF){
    $outCPF = substr($inCPF, 0, 3).".";
    $outCPF .= substr($inCPF, 3, 3).".";
    $outCPF .= substr($inCPF, 6, 3)."-";
    $outCPF .= substr($inCPF, 9, 2);
    return trim($outCPF);
}
function achaCliente($inCPF){
    global $conexao;
    if ($result = $conexao->query("SELECT * FROM cliente WHERE cli_cpf = '".$inCPF."'")){
        if ($result->num_rows > 0) {
            // Achou
            return true;    
        } else {
            return false;
        }
        $result->close();
    }
} // Fim function achaCliente($inCPF, $inAcao){
function achaProduto($inProdDesc){
    global $conexao;
    if ($result = $conexao->query("SELECT * FROM produto WHERE prod_desc LIKE '%".$inProdDesc."%'")){
        if ($result->num_rows > 0) {
            // Achou
            return true;    
        } else {
            return false;
        }
        $result->close();   
    }
} // Fim function achaProduto($inProdDesc){ 
function achaItem($inItemVendaId, $inItemProdId){
    global $conexao;
    if ($result = $conexao->query("SELECT * FROM item WHERE item_venda_id = ".$inItemVendaId." AND
                                                            item_prod_id = ".$inItemProdId)){
        if ($result->num_rows > 0) {
            // Achou
            return true;    
        } else {
            return false;
        }
        $result->close();   
    }
} // Fim function achaProduto($inProdDesc){ 
function carregaDados($inCPF){
    global $conexao;
    if ($result = $conexao->query("SELECT * FROM cliente WHERE cli_cpf = '".$inCPF."'")){
        $linha = $result->fetch_assoc();
    }
    $result->close();    
}
?>