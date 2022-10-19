function setMask(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("executeMask()", 1)
}

function executeMask() {
    v_obj.value=v_fun(v_obj.value)
}

function maskCPF(v) {
    v = v.replace(/\D/g, "")  //Remove tudo o que não é dígito
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
                                             //de novo (para o segundo bloco de números)
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

function maskTelefone(v) {
    v = v.replace(/\D/g, "") //Remove tudo que nao é dígito
    v = v.replace(/^(\d\d)(\d)/g, "($1) $2") //Coloca parenteses nos dois primeiros dígitos
    v = v.replace(/(\d{5})(\d)/, "$1-$2") // Adiciona um hífen entre o quarto e quinto dígitos
    return v 
}