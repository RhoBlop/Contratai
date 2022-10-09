// define um timeout para ser usado em fetch requests
// basta apenas fazer um clearTimeout caso sucesso na requisição
function timeoutConnection() {
    return setTimeout(() => {
        formErro("Algum erro ocorreu. Tente novamente mais tarde!");
    }, 6000);
}

// redireciona para o index e abre o modal de login
function redirectLogin() {
    setOpenModal("#modal-login");
    window.location.href = "index.php";
}

// função executada sempre que uma imagem do input type=file é selecionada
// lê os dados da imagem e coloca em uma tag img, com id passado por parâmetro (para que o usuário pode visualizar a imagem selecionada)
function showSelectedImg(event, idImg) {
    let input = event.target;

    if (input.files.length === 1) {
        // pega o arquivo selecionado pelo input
        let file = input.files[0];

        let reader = new FileReader();
        // ler a imagem binária em formato de dataURL (base64)
        reader.readAsDataURL(file);

        reader.onload = function (e) {
            // quando um arquivo for lido, colocar o base64 na imagem com id passada por parâmetro
            document.querySelector(idImg).src = e.target.result;
        };
    }
}

// adicionado no onchange do confirmaSenha para mostrar mensagem de erro caso as senhas sejam diferentes
function confirmarSenha(event, idDivSenha, idDivErro) {
    let divSenha = document.querySelector(idDivSenha);
    let divConfirmaSenha = event.target;

    if (divSenha.value !== "" && divConfirmaSenha.value !== "") {
        let divErro = document.querySelector(idDivErro);
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
