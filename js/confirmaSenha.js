// adicionado no onchange do confirmaSenha para checar se as duas senhas são iguais
function confirmaSenha(event, idDivSenha) {
    let divSenha = document.querySelector(idDivSenha);
    let divConfirmaSenha = event.target;

    if (divSenha.value !== "" && divConfirmaSenha.value !== "") {
        let divErro = divConfirmaSenha.nextElementSibling;
        if (divSenha.value != divConfirmaSenha.value) {
            // indica erro ao usuário, alterando coloração dos inputs e escrevendo mensagem de erro
            divConfirmaSenha.classList.add("inputErro");
            divSenha.classList.add("inputErro");

            divErro.style.display = "block";
        } else {
            // reseta os estilos dos inputs
            divConfirmaSenha.classList.remove("inputErro");
            divSenha.classList.remove("inputErro");
            divErro.style.display = "none";
        }
    }
}
