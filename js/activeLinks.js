window.addEventListener("DOMContentLoaded", (event) => {
    let current = location.pathname.replace(/\//g, "");

    // links da sidebar na tela de perfil
    let sidebar = document.querySelector("#sidebar");
    if (sidebar) {
        // selecionar todos os elementos com classe "nav-link" dentro da sidebar
        let links = sidebar.querySelectorAll(".nav-link");
        // spread da NodeList em uma array [...var]
        for (link of [...links]) {
            // se href do link for igual 
            if (link.getAttribute("href") == current) {
                link.classList.add("active");
            } else {
                link.classList.add("link-secondary");
            }
        }
    }

    // links do header não logado
    let header = document.querySelector("#mainHeader");
    if (header) {
        // selecionar todos os elementos com classe "nav-link" dentro do header
        let links = header.querySelectorAll(".nav-link");
        // spread da NodeList em uma array [...var]
        for (link of [...links]) {
            let linkHref = link.getAttribute("href");
            console.log(linkHref);

            if (current === "" && linkHref === "index.php") {
                // se o pathname atual for vazio, provavelmente estamos no index.php
                link.classList.add("active");
            } else if (linkHref === current) {
                // se href do link for igual ao pathname da url, adicionar classe active ao link
                link.classList.add("active");
            } else {
                link.classList.add("link-secondary");
            }
        }
    }
});