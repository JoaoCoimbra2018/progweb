function validaCPF(inCPF) {    
    var cpf = inCPF.replace(/[^\d]+/g,"");    
    if(cpf == "") return false;    
    // Elimina CPFs invalidos conexaohecidos    
    if (cpf.length != 11 || 
        cpf == "00000000000" || 
        cpf == "11111111111" || 
        cpf == "22222222222" || 
        cpf == "33333333333" || 
        cpf == "44444444444" || 
        cpf == "55555555555" || 
        cpf == "66666666666" || 
        cpf == "77777777777" || 
        cpf == "88888888888" || 
        cpf == "99999999999")
            return false;        
    // Valida 1o digito    
    add = 0;    
    for (i=0; i < 9; i ++)        
        add += parseInt(cpf.charAt(i)) * (10 - i);    
        rev = 11 - (add % 11);    
        if (rev == 10 || rev == 11)        
            rev = 0;    
        if (rev != parseInt(cpf.charAt(9)))        
            return false;        
    // Valida 2o digito    
    add = 0;    
    for (i = 0; i < 10; i ++)        
        add += parseInt(cpf.charAt(i)) * (11 - i);    
    rev = 11 - (add % 11);    
    if (rev == 10 || rev == 11)    
        rev = 0;    
    if (rev != parseInt(cpf.charAt(10)))
        return false;        
    return true;   
}  // Fim function validarCPF(cpf) 
function Alerta(inTipo, inMsg){
    alert(inTipo+"\n"+inMsg);
}
function confereCPF(inCPF){
    //alert("Confere CPF");
    var conf = true;
    if (inCPF+"" == "") {
        Alerta("Erro", "CPF tem que ser informado");
        conf = false;
    } else {
        if (!validaCPF(inCPF)) {
            Alerta("Erro", "CPF inválido");
            conf = false;
        } 
    }    
    //alert("Conf: "+conf);
    return conf;
}
function confereSenhas(inSenha, inSenhaRepetida){
    var conf = true;
    if (inSenha !== inSenhaRepetida) {
        //Alerta("Erro", "Senhas não conferem");
        conf = false;
    }
    return conf;
}
function formataCPF(inCPF){
    outCPF = inCPF.substr(0, 3)+".";
    outCPF = outCPF+inCPF.substr(3, 3)+".";
    outCPF = outCPF+inCPF.substr(6, 3)+"-";
    outCPF = outCPF+inCPF.substr(9, 2);
    return outCPF;
}