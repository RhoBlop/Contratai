function limpaFormCEP() {
    document.getElementById('bairro').value=("");
    document.getElementById('cidade').value=("");
    document.getElementById('estado').value=("");
}

function cepCallback(c) {
    if ("erro" in c) {
        limpaFormCEP();
        formErro("Seu CEP não foi encontrado");
    }

    else {
        document.getElementById('bairro').value=(c.bairro);
        document.getElementById('cidade').value=(c.localidade);
        document.getElementById('estado').value=(c.uf);    
        hideFeedback();
    }

}

function pesquisaCEP(v) {
    var cep = v.replace(/\D/g, "");

    if (cep != "") {
        var validacep = /^[0-9]{8}$/;

        if (validacep.test(cep)) {
            document.getElementById('bairro').value="---";
            document.getElementById('cidade').value="---";
            document.getElementById('estado').value="---";    
        
            var script = document.createElement('script');

            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=cepCallback';
        
            document.body.appendChild(script);
        }
        else {
            limpaFormCEP();
            formErro("Formato de CEP inválido")
        }
    }
    else {
        limpaFormCEP();
    }
}