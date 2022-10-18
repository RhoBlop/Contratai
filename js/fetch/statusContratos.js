async function aceitarContrato(event) {
    let btn = event.target;
    let contratoEl = findClosestAncestor(btn, "item-contrato");
    let emAndamentoEl = document.querySelector("#emAndamentoContratado");

    // moves contratoEl to another accordion item and, if the accordion has empty message, deletes it
    let emptyAccordion = emAndamentoEl.querySelector(".empty-accordion");
    if (emptyAccordion) {
        emptyAccordion.remove();
    }
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
    let contratoEl = findClosestAncestor(btn, "item-contrato");

    contratoEl.remove();

    let idContrato = contratoEl.dataset.contratoid;
    // problemas de segurança, mas né... :/
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
    let contratoEl = findClosestAncestor(btn, "item-contrato");

    contratoEl.remove();

    let idContrato = contratoEl.dataset.contratoid;
    // problemas de segurança, mas né... :/
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

async function aceitarFimContrato(event) {}

async function updateStatusContrato(idContrato, idStatus) {
    try {
        let response = await fetch(
            `./php/post/contrato/updateStatusContrato.php`,
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
