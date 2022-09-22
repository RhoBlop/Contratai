let idDivFeedback = "#feedbackUsuario";

function loading() {
    let feedbackDiv = document.querySelector(idDivFeedback);
    feedbackDiv.style.display = "block";
    // feedbackDiv.style.maxHeight = "50px";
    feedbackDiv.style.backgroundColor = "#026773";
    feedbackDiv.innerText = "Aguarde um instante...";
}

function formErro(textErro) {
    let feedbackDiv = document.querySelector(idDivFeedback);
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
            localStorage.setItem("openModal", "true");
            window.location.href = "index.php";
        }
    } else {
        
    }
}


// função de formulário responsável por criar uma nova sessão de usuário
async function sendLogin(event) {
    event.preventDefault();

    let formData = new URLSearchParams(new FormData(event.target)).toString();

    loading();

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
        window.location.href = "home.php";
    }
}

// função que faz update das informações de usuário
async function sendUpdate(event) {
    event.preventDefault();

    let formData = new FormData(event.target);

    loading();
    
    let response = await fetch("./API/user/updateInfo.php", {
        method: "POST",
        credentials: "same-origin",
        body: formData
    });
    let data = await response.json();

    let { erro } = data;
    if (erro) {
        formErro(erro);
    }
    
    let { action } = data;
    if (action) {
        await savesLoggedUser();

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
        
        let response = await fetch("./API/user/updateSenha.php", {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: formData
        });
        let data = await response.text();
        console.log(data);

        let { erro } = data;
        if (erro) {
            formErro(erro);
        }
        
        let { action } = data;
        if (action) {
            window.location.href = "perfil.php";
        }
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
        window.location.href = "excluido.php";
    }
}