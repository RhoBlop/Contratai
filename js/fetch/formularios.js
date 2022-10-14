var idDivFeedback = "#feedbackUsuario";

function loading() {
    let feedbackDiv = document.querySelector(idDivFeedback);
    feedbackDiv.style.display = "block";
    feedbackDiv.style.backgroundColor = "#026773";
    feedbackDiv.innerText = "Aguarde um instante...";
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
    let confirmaSenha = document.querySelector("#confirmaSenha").value;

    if (senha === confirmaSenha) {
        // transforma os dados do formulário para o formato x-www-form-urlencoded
        let formData = new URLSearchParams(
            new FormData(event.target)
        ).toString();

        loading();
        timeout = timeoutConnection();

        let response = await fetch("./php/post/user/cadastro.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: formData,
        });
        let data = await response.json();

        if (data.erro) {
            let { erro } = data;
            formErro(erro);
        }

        if (data.dados) {
            setOpenModal("#modal-login");
            window.location.href = "index.php";
        }
        clearTimeout(timeout);
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

    let response = await fetch("./php/post/login.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: formData,
    });
    let data = await response.json();

    if (data.erro) {
        let { erro } = data;
        formErro(erro);
    }

    if (data.dados) {
        window.location.href = "home.php";
    }
    clearTimeout(timeout);
}

// função que faz update das informações de usuário
async function sendUpdate(event) {
    event.preventDefault();

    let formData = new FormData(event.target);

    loading();
    timeout = timeoutConnection();

    let response = await fetch("./php/post/user/updateInfo.php", {
        method: "POST",
        credentials: "same-origin",
        body: formData,
    });
    let data = await response.json();

    if (data.erro) {
        let { erro } = data;
        formErro(erro);
    }

    if (data.dados) {
        setOpenToast(
            "#notifyToast",
            "Edição de perfil",
            "Edição de perfil realizada com sucesso"
        );
        window.location.href = "perfil.php";
    }
    clearTimeout(timeout);
}

async function sendUpdateSenha(event) {
    event.preventDefault();

    let senhaNova = document.querySelector("#senhaNova").value;
    let confirmaSenhaNova = document.querySelector("#confirmaSenhaNova").value;

    if (senhaNova === confirmaSenhaNova) {
        // transforma os dados do formulário para o formato x-www-form-urlencoded
        let formData = new URLSearchParams(
            new FormData(event.target)
        ).toString();

        loading();
        timeout = timeoutConnection();

        let response = await fetch("./php/post/user/updateSenha.php", {
            method: "POST",
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: formData,
        });
        let data = await response.json();

        if (data.erro) {
            let { erro } = data;
            formErro(erro);
        }

        if (data.dados) {
            setOpenToast(
                "#notifyToast",
                "Edição de senha",
                "Edição da senha realizada com sucesso"
            );
            window.location.href = "perfil.php";
        }
        clearTimeout(timeout);
    } else {
        formErro("As senhas não são iguais");
    }
}

async function logout() {
    let response = await fetch("./php/post/logout.php", {
        method: "GET",
        credentials: "same-origin",
    });
    let data = await response.json();

    if (data.dados) {
        setOpenModal("#modal-login");
        window.location.href = "index.php";
    }
}

async function deleteUser() {
    let response = await fetch("./php/post/user/deletar.php", {
        method: "GET",
        credentials: "same-origin",
    });
    let data = await response.json();

    if (data.dados) {
        window.location.href = "excluido.php";
    }
}

async function sendSolicitacaoContrato(event) {
    event.preventDefault();

    // transforma os dados do formulário para o formato x-www-form-urlencoded
    let formData = new URLSearchParams(new FormData(event.target)).toString();

    loading();
    timeout = timeoutConnection();

    let response = await fetch("./php/post/contrato/solicitacaoContrato.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        credentials: "same-origin",
        body: formData,
    });
    let data = await response.json();

    if (data.erro) {
        let { erro } = data;
        formErro(erro);
    }

    if (data.dados) {
        setOpenToast(
            "#notifyToast",
            "Contratação",
            "Solicitação de contratatação enviada com sucesso"
        );
        window.location.reload();
    }
    clearTimeout(timeout);
}
