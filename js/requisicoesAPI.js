// função de formulário responsável por criar um novo usuário
async function sendCadastro(event, idDivFeedback) {
    event.preventDefault();

    // transforma os dados do formulário para o formato x-www-form-urlencoded
    let formData = new URLSearchParams(new FormData(event.target)).toString();

    let feedbackDiv = document.querySelector(idDivFeedback);
    feedbackDiv.style.display = "block";
    // feedbackDiv.style.maxHeight = "50px";
    feedbackDiv.style.backgroundColor = "#026773";
    feedbackDiv.innerText = "Aguarde um instante...";

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
        feedbackDiv.style.backgroundColor = "#cf1c0e";
        feedbackDiv.innerText = erro;
    } 
    
    let { action } = data;
    if (action) {
        localStorage.setItem("openModal", "true");
        window.location.href = "index.php";
    }
}


// função de formulário responsável por criar uma nova sessão de usuário
async function sendLogin(event, idDivFeedback) {
    event.preventDefault();

    let formData = new URLSearchParams(new FormData(event.target)).toString();

    let feedbackDiv = document.querySelector(idDivFeedback);
    feedbackDiv.style.display = "block";
    // feedbackDiv.style.maxHeight = "50px";
    feedbackDiv.style.backgroundColor = "#026773";
    feedbackDiv.innerText = "Aguarde um instante...";

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
        feedbackDiv.style.backgroundColor = "#cf1c0e";
        feedbackDiv.innerText = erro;
    }
    
    let { dados } = data;
    if (dados) {
        // salva usuário logado no localStorage
        await savesLoggedUser();

        window.location.href = "home.php";
    }
}

// função que faz update das informações de usuário
async function sendUpdate(event, idDivFeedback) {
    event.preventDefault();

    let formData = new FormData(event.target);

    let feedbackDiv = document.querySelector(idDivFeedback);
    feedbackDiv.style.display = "block";
    // feedbackDiv.style.maxHeight = "50px";
    feedbackDiv.style.backgroundColor = "#026773";
    feedbackDiv.innerText = "Aguarde um instante...";
    
    let response = await fetch("./API/user/updateInfo.php", {
        method: "POST",
        credentials: "same-origin",
        body: formData
    });
    let data = await response.json();

    let { erro } = data;
    if (erro) {
        feedbackDiv.style.backgroundColor = "#cf1c0e";
        feedbackDiv.innerText = erro;
    }
    
    let { action } = data;
    if (action) {
        await savesLoggedUser();

        window.location.href = "perfil.php";
    }
}


// salva os dados do usuário no localStorage (solução temporária porque o banco estava demorando mais de 2 segundos para retornar um usuário)
async function savesLoggedUser() {
    console.log("getting logged user");
    let response = await fetch("./API/user/get.php", {
        method: "GET",
        credentials: "same-origin",
    })
    let { dados } = await response.json();

    localStorage.setItem("currentUser", JSON.stringify(dados));

    return true;
}


// retorna user salvo do localStorage
function getLocalStorageUser() {
    let user = localStorage.getItem("currentUser");

    return JSON.parse(user);
}

function deleteLocalStorageUser() {
    localStorage.removeItem("currentUser");

    return true;
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
        deleteLocalStorageUser();
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
        deleteLocalStorageUser();
        window.location.href = "excluido.php";
    }
}