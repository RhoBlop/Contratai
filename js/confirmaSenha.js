// adicionado no onchange do confirmaSenha para checar se as duas senhas são iguais
function confirmaSenha(event, idDivSenha, idDivErro) {
    console.log("abc");
    let divSenha = document.querySelector(idDivSenha);
    let divConfirmaSenha = event.target;

    if (divSenha.value !== "" && divConfirmaSenha.value !== "") {
        let erroMsg = document.querySelector(idDivErro);
        if (divSenha.value != divConfirmaSenha.value) {
            divConfirmaSenha.classList.add("inputSenhaErrada");
            divSenha.classList.add("inputSenhaErrada");

            erroMsg.style.color = "#cf1c0e";
            erroMsg.textContent = "As senhas precisam ser iguais";
        } else {
            divConfirmaSenha.classList.remove("inputSenhaErrada");
            divSenha.classList.remove("inputSenhaErrada");
            erroMsg.textContent = "";
        }
    }

}