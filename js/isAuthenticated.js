isAuthenticated()
    .then( auth => {
        if (!auth) {
            window.location.replace("index.php");
        } else {
            console.log("Usuário autenticado");
        }
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