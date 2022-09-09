isAuthenticated()
    .then( auth => {
        let atual = location.pathname;
        let paginaLiberadas = ["/", "/index.php", "/cadastro.php"];
        if (auth && paginaLiberadas.includes(atual)) {
            // caso já esteja logado, o usuário é redirecionado à home
            window.location.href = "home.php";
        } else if (auth) {
            // usuário autenticado e pode ficar normalmente na página atual
            console.log("Usuário autenticado");
        } else {
            // usuário não autenticado, é redirecionado ao index
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