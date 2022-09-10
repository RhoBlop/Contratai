// função de formulário responsável por criar um novo usuário
async function sendCadastro(event) {
    event.preventDefault();

    // transforma os dados do formulário para o formato x-www-form-urlencoded
    let formData = new URLSearchParams(new FormData(event.target)).toString();

    let response = await fetch("./API/user/register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: formData
    });
    let data = await response.json();
    
    let {resposta} = data;
    if (resposta === "sucesso no cadastro") {
        localStorage.setItem("openModal", "true");
        window.location.href = "index.php";
    }
}


// função de formulário responsável por criar uma nova sessão de usuário
async function sendLogin(event, idErrorDiv) {
    event.preventDefault();

    let formData = new URLSearchParams(new FormData(event.target)).toString();

    let response = await fetch("./API/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: formData
    });
    let data = await response.json();

    // mensagem enviada pela API
    let { resposta } = data;
    if (resposta === "sucesso no login") {
        window.location.href = "home.php";
    } else if (resposta === "credenciais invalidas") {
        console.log("Credenciais de login inválidas");
        // append mensagem de erro no formulário
    } else {
        // para fins de debug por enquanto
        console.log(data);
    }
}

// função que faz update das informações de usuário
async function sendUpdate(event) {
    event.preventDefault();

    let formData = new FormData(event.target);
    
    let response = await fetch("./API/user/updateInfo.php", {
        method: "POST",
        credentials: "same-origin",
        body: formData
    });
    let data = await response.text();

    console.log(data);
}


async function getLoggedUser() {
    console.log("getting logged user");
    let response = await fetch("./API/user/get.php", {
        method: "GET",
        credentials: "same-origin",
    })
    let user = await response.json();

    return user;
}


async function logout() {
    console.log("logging out");
    let response = await fetch("./API/logout.php", {
        method: "GET",
        credentials: "same-origin",
    });
    let data = await response.json();

    let { logout } = data;
    if (logout) {
        localStorage.setItem("openModal", "true");
        window.location.href = "index.php";
    }
}


async function deleteUser() {
    let response = await fetch("./API/user/delete.php", {
        method: "GET",
        credentials: "same-origin",
    });
    let data = await response.json();

    let { deleted } = data;
    if (deleted) {
        window.location.href = "index.php";
    }
}