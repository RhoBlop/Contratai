// função de formulário responsável por criar um novo usuário
async function sendCadastro(event) {
    event.preventDefault();

    // transforma os dados do formulário para o formato x-www-form-urlencoded
    let formData = new URLSearchParams(new FormData(event.target)).toString();

    let response = await fetch("./API/user/register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "Accept": "application/json"
        },
        body: formData
    });
    let data = await response.json();
    console.log(data);
}

// verifica se o email já está cadastrado no banco de dados
// adicionado ao onblur de input para comodidade do usuário (não é necessário enviar o formulário para checar)
async function checkIfValidEmail() {

}

// função de formulário responsável por criar uma nova sessão de usuário
async function sendLogin(event) {
    event.preventDefault();

    let formData = new URLSearchParams(new FormData(event.target)).toString();

    let response = await fetch("./API/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "Accept": "application/json"
        },
        body: formData
    });
    let data = await response.json();

    // mensagem enviada pela API
    let { resposta } = data;
    if (resposta === "sucesso no login") {
        window.location.replace("home.php");
    } else if (resposta === "credenciais invalidas") {
        console.log("Credenciais de login inválidas");
        // append mensagem de erro no formulário
    }
}