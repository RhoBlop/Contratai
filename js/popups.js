// uso do localStorage para controlar o aparecimento de elementos em outras telas
// setOpen = define para abrir um toast/modal em outra página; usado antes de redirecionar páginas
// create = abre imediatamente

function setOpenModal(idModal) {
    localStorage.setItem("openModal", idModal);
}

function setOpenToast(idToast, title, message) {
    localStorage.setItem("openToast", `${idToast},${title},${message}`);
}

function checkForOpenModal() {
    let idModal = localStorage.getItem("openModal");

    if (idModal) {
        openModal(idModal);

        localStorage.removeItem("openModal");
    }
}

function checkForOpenToast() {
    let storage = localStorage.getItem("openToast");

    if (storage) {
        let [idToast, title, message] = storage.split(",");
        openToast(idToast, title, message);

        localStorage.removeItem("openToast");
    }
}

function openModal(idModal) {
    let modal = new bootstrap.Modal(document.querySelector(idModal), {});
    modal.show();
}

function openToast(idToast, title, message) {
    let divTitle = document.querySelector(`${idToast} .toast-header strong`);
    divTitle.textContent = title;

    let divMessage = document.querySelector(`${idToast} .toast-body`);
    divMessage.textContent = message;

    let toast = new bootstrap.Toast(document.querySelector(idToast));
    toast.show();
}

function createToast(title, message, toastClass, idToast = "notifyToast") {
    // wrapper que pode ter múltiplos toasts
    let toastContainer = document.querySelector("#toastContainer");
    if (!toastContainer) {
        toastContainer = document.createElement("div");
        toastContainer.classList.add(
            "toast-container",
            "position-fixed",
            "bottom-0",
            "end-0",
            "p-3"
        );
        toastContainer.setAttribute("id", "toastContainer");
        document.body.append(toastContainer);
    }

    // DIV MAIS EXTERNA DE UM TOAST
    let toast = document.createElement("div");
    toast.classList.add("toast");
    setAttributes(toast, {
        id: idToast,
        role: "alert",
        "aria-live": "assertive",
        "aria-atomic": "true",
    });

    // TOAST HEADER
    let toastHeader = document.createElement("div");
    toastHeader.classList.add("toast-header");

    // toast header img
    let toastImg = document.createElement("img");
    toastImg.classList.add("rounded", "me-2");
    setAttributes(toastImg, {
        src: "images/logo/favicon.svg",
        width: "18px",
        height: "18px",
    });
    toastHeader.append(toastImg);

    // toast header title
    let toastTitle = document.createElement("strong");
    toastTitle.classList.add("me-auto");
    toastTitle.textContent = title ? title : "Contrataí";
    toastHeader.append(toastTitle);

    // toast header dismiss button
    let toastBtn = document.createElement("button");
    toastBtn.classList.add("btn-close");
    setAttributes(toastBtn, {
        type: "button",
        "data-bs-dismiss": "toast",
        "aria-label": "Close",
    });
    toastHeader.append(toastBtn);

    // TOAST BODY
    let toastBody = document.createElement("div");
    toastBody.classList.add("toast-body");
    toastBody.textContent = message ? message : "Alguma coisa deu errado";

    toast.append(toastHeader);
    toast.append(toastBody);

    toastContainer.prepend(toast);

    let bsToast = new bootstrap.Toast(toast, {
        animation: true,
        autohide: false,
    });
    bsToast.show();
}
