window.addEventListener("DOMContentLoaded", (event) => {
    let current = location.pathname.replace(/\//g, "");
    let sidebar = document.querySelector("#sidebar");
    console.log(current);
    if (sidebar) {
        let links = sidebar.querySelectorAll(".nav-link");
        for (link of [...links]) {
            // se href do link for igual 
            if (link.getAttribute("href") == current) {
                link.classList.add("active");
            } else {
                link.classList.add("link-secondary");
            }
        }
    }
});