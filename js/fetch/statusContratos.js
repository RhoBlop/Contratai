async function aceitarContrato(event) {
    let btn = event.target;
    let contratoEl = findClosestAncestorByClass(btn, "id-contrato");

    moveContrato(contratoEl, "#")
    
    // deleta os botões de "aceitar" e "recusar" do card
    let buttons = contratoEl.querySelector(".contrato-buttons");
    buttons.textContent = "";

    // adiciona o botão de "finalizar contrato" no card
    let btnFinalizar = document.createElement("button");
    btnFinalizar.classList.add("btn", "btn-green");
    btnFinalizar.textContent = "O contrato foi realizado!";
    btnFinalizar.addEventListener("click", solicitarFimContrato);
    buttons.appendChild(btnFinalizar);

    

    let idContrato = contratoEl.dataset.contratoid;
    // problemas de segurança, mas né... :/
    let idStatus = 2;
    let data = await updateStatusContrato(idContrato, idStatus);

    if (data.dados) {
        createToast(
            "Status do contrato atualizado",
            "O contrato foi aceito com sucesso! Agora é hora de pôr a mão na massa",
            "success-notify",
            idContrato
        );
    } else {
        createToast(
            "Erro na operação",
            "Não foi possível atualizar o status do contrato, recarregue a página e tente novamente",
            "failure-notify",
            idContrato
        );
    }
}

async function recusarContrato(event) {
    let btn = event.target;
    let contratoEl = findClosestAncestorByClass(btn, "id-contrato");

    contratoEl.remove();

    let idContrato = contratoEl.dataset.contratoid;
    let idStatus = 5;
    let data = await updateStatusContrato(idContrato, idStatus);

    if (data.dados) {
        createToast(
            "Status do contrato atualizado",
            "O contrato foi recusado com sucesso",
            "success-notify",
            idContrato
        );
    } else {
        createToast(
            "Erro na operação",
            "Não foi possível atualizar o status do contrato, recarregue a página e tente novamente",
            "failure-notify",
            idContrato
        );
    }
}

async function solicitarFimContrato(event) {
    let btn = event.target;
    let contratoEl = findClosestAncestorByClass(btn, "id-contrato");

    contratoEl.remove();

    let idContrato = contratoEl.dataset.contratoid;
    let idStatus = 3;
    let data = await updateStatusContrato(idContrato, idStatus);

    if (data.dados) {
        createToast(
            "Status do contrato atualizado",
            "Uma solicitação foi enviada ao próximo usuário",
            "success-notify",
            idContrato
        );
    } else {
        createToast(
            "Erro na operação",
            "Não foi possível atualizar o status do contrato, recarregue a página e tente novamente",
            "failure-notify",
            idContrato
        );
    }
}

async function aceitarFimContrato(event) {
    let btn = event.target;
    let contratoEl = findClosestAncestorByClass(btn, "id-contrato");

    contratoEl.remove();

    let idContrato = contratoEl.dataset.contratoid;
    let idStatus = 4;
    let data = await updateStatusContrato(idContrato, idStatus);

    if (data.dados) {
        createToast(
            "Status do contrato atualizado",
            "O contrato foi finalizado com sucesso",
            "success-notify",
            idContrato
        );
    } else {
        createToast(
            "Erro na operação",
            "Não foi possível atualizar o status do contrato, recarregue a página e tente novamente",
            "failure-notify",
            idContrato
        );
    }
}

async function updateStatusContrato(idContrato, idStatus) {
    try {
        let response = await fetch(
            `./php/post/contrato/updateStatus.php`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                credentials: "same-origin",
                body: `idContrato=${idContrato}&idStatus=${idStatus}`,
            }
        );
        let data = await response.json();

        return data;
    } catch (error) {
        console.error(error);
    }
}

function moveContrato(contrato, divId) {
    let targetAccordion = document.querySelector(`#${divId}`);
    let isEmptyAccordion = targetDiv.querySelector(".empty-accordion");

    // if the accordion has an empty message, deletes the message
    if (isEmptyAccordion) {
        emptyAccordion.remove();
    }

    targetAccordion.appendChild(contrato);
}

function addButtonsContrato(contrato)