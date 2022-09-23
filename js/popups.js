// uso do localStorage para controlar o aparecimento de elementos em outras telas

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
        let [ idToast, title, message ] = storage.split(",");
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