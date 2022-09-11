isAuthenticated()
    .then( auth => {
        let atual = location.pathname;
        let paginasLiberadas = ["/", "/index.php", "/cadastro.php", "/sobre.php", "/ajuda.php", "/excluido.php"];
        if (auth && paginasLiberadas.includes(atual)) {
            // caso já esteja logado e em uma "página não logada" o usuário é redirecionado à home
            window.location.href = "home.php";
        } else if (auth) {
            // caso o usuário esteja logado, nada acontece
            console.log("Usuário autenticado");
        } else if (!auth && paginasLiberadas.includes(atual)) {
            // caso o usuário não esteja autenticado e esteja em páginas liberadas, não faz nada
            console.log("Usuário não autenticado");
        } else {
            // usuário tentou entrar em alguma página que necessita de autenticação
            window.location.href = "index.php";
        }
    })
    .catch( err => {
        // DOMException: Operation was aborted (o dom não terminou de carregar)
        console.error(err);
    });

async function isAuthenticated() {
    let response = await fetch("./API/authenticate.php", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "Accept": "application/json"
        }
    });
    let data = await response.json();
    let { auth } = data;

    return auth;
}