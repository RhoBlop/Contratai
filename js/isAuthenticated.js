isAuthenticated()
    .then( auth => {
        if (!auth) {
            window.location.replace("index.php");
        }
        console.log("Usuário autenticado");
    });

async function isAuthenticated() {
    let response = await fetch("./API/apiAuthenticate.php", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "Accept": "application/json"
        }
    });
    let data = await response.json();
    let authenticated = data.resposta;

    return authenticated;
}