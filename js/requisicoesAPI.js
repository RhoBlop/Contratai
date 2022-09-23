var idDivFeedback = "#feedbackUsuario";

function loading() {
    let feedbackDiv = document.querySelector(idDivFeedback);
    feedbackDiv.style.display = "block";
    feedbackDiv.style.backgroundColor = "#026773";
    feedbackDiv.innerText = "Aguarde um instante...";
}

function timeoutConnection() {
    return setTimeout(() => {
        formErro("Algum erro ocorreu. Tente novamente mais tarde!");
    }, 6000)
}

function formErro(textErro) {
    let feedbackDiv = document.querySelector(idDivFeedback);
    feedbackDiv.style.display = "block";
    feedbackDiv.style.backgroundColor = "#cf1c0e";
    feedbackDiv.innerText = textErro;
}

// função de formulário responsável por criar um novo usuário
async function sendCadastro(event) {
    event.preventDefault();

    let senha = document.querySelector("#senha").value;
    let confirmSenha = document.querySelector("#confirmSenha").value;

    if (senha === confirmSenha) {
        // transforma os dados do formulário para o formato x-www-form-urlencoded
        let formData = new URLSearchParams(new FormData(event.target)).toString();
    
        loading();
        timeout = timeoutConnection();
    
        let response = await fetch("./API/user/register.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: formData
        });
        let data = await response.json();
        
        let { erro } = data;
        if (erro) {
            formErro(erro);
        } 
        
        let { action } = data;
        if (action) {
            setOpenModal("#modal-login");
            clearTimeout(timeout);
            window.location.href = "index.php";
        }
    } else {
        formErro("As senhas não são iguais");
    }
}


// função de formulário responsável por criar uma nova sessão de usuário
async function sendLogin(event) {
    event.preventDefault();

    let formData = new URLSearchParams(new FormData(event.target)).toString();

    loading();
    timeout = timeoutConnection();

    let response = await fetch("./API/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: formData
    });
    let data = await response.json();

    let { erro } = data;
    if (erro) {
        formErro(erro);
    }
    
    let { action } = data;
    if (action) {
        clearTimeout(timeout);
        window.location.href = "home.php";
    }
}

// função que faz update das informações de usuário
async function sendUpdate(event) {
    event.preventDefault();

    let formData = new FormData(event.target);

    loading();
    timeout = timeoutConnection();
    
    let response = await fetch("./API/user/updateInfo.php", {
        method: "POST",
        credentials: "same-origin",
        body: formData
    });
    let data = await response.json();
    timeout = timeoutConnection();

    let { erro } = data;
    if (erro) {
        formErro(erro);
    }
    
    let { action } = data;
    if (action) {
        setOpenToast("#notifyToast", "Edição de perfil", "Edição de perfil realizada com sucesso");
        clearTimeout(timeout);
        window.location.href = "perfil.php";
    }
}


async function sendUpdateSenha(event) {
    event.preventDefault();

    let senhaNova = document.querySelector("#senhaNova").value;
    let confirmSenhaNova = document.querySelector("#confirmSenhaNova").value;

    if (senhaNova === confirmSenhaNova) {
        // transforma os dados do formulário para o formato x-www-form-urlencoded
        let formData = new URLSearchParams(new FormData(event.target)).toString();

        loading();
        timeout = timeoutConnection();
        
        let response = await fetch("./API/user/updateSenha.php", {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: formData
        });
        let data = await response.json();

        let { erro } = data;
        if (erro) {
            formErro(erro);
        }
        
        let { action } = data;
        if (action) {
            setOpenToast("#notifyToast", "Edição de senha", "Edição da senha realizada com sucesso");
            clearTimeout(timeout);
            window.location.href = "perfil.php";
        }
    } else {
        formErro("As senhas não são iguais");
    }
}


async function logout() {
    console.log("logging out");
    let response = await fetch("./API/logout.php", {
        method: "GET",
        credentials: "same-origin",
    });
    let data = await response.json();

    let { action } = data;
    if (action) {
        setOpenModal("#modal-login")
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
        window.location.href = "excluido.php";
    }
}