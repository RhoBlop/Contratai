//TODO[epic=MudancaStatus]: Rodar o banco novamente para atualizar os status de contrato (adicionar "solicitação de finalizacao") e alterar os status nos formulários a seguir

async function aceitarContrato(event) {
    let btn = event.target;
    let contratoEl = findClosestAncestorByClass(btn, "item-contrato");
    let emAndamentoEl = document.querySelector("#emAndamentoContratado");

    // moves contratoEl to another accordion item and, if the accordion has empty message, deletes it
    let emptyAccordion = emAndamentoEl.querySelector(".empty-accordion");
    if (emptyAccordion) {
        emptyAccordion.remove();
    }
    // deleta os botões de "aceitar" e "recusar" do card
    let buttons = contratoEl.querySelector(".accordion-buttons");
    buttons.textContent = "";

    // adiciona o botão de "finalizar contrato" no card
    let btnFinalizar = document.createElement("button");
    btnFinalizar.classList.add("btn", "btn-green");
    btnFinalizar.textContent = "O contrato foi realizado!";
    btnFinalizar.addEventListener("click", solicitarFimContrato);
    buttons.appendChild(btnFinalizar);

    emAndamentoEl.appendChild(contratoEl);

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
    let contratoEl = findClosestAncestorByClass(btn, "item-contrato");

    contratoEl.remove();

    let idContrato = contratoEl.dataset.contratoid;
    //NOTE: Recusar - novo id 5
    let idStatus = 4;
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
    let contratoEl = findClosestAncestorByClass(btn, "item-contrato");

    contratoEl.remove();

    let idContrato = contratoEl.dataset.contratoid;
    //NOTE: Solicitacao fim - novo id 3
    let idStatus = 4;
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
    let contratoEl = findClosestAncestorByClass(btn, "item-contrato");

    contratoEl.remove();

    let idContrato = contratoEl.dataset.contratoid;
    //NOTE: Aceitar fim - novo id 4
    let idStatus = 5;
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
