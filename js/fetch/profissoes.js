let especsAbortControl = null;

let selectProf = document.querySelector("#addProf");
let selectEspec = document.querySelector("#addEspec");
let confirmBtn = document.querySelector("#addEspecBtn");

let modal = document.querySelector("#modalAddProf");
let modalBody = document.querySelector("#modalBody");
let feedbackDiv = document.querySelector("#feedbackUsuario");

// pega as especs após uma profissão ser selecionada
selectProf.onchange = async () => {
    let profId = selectProf.value;
    clearSelectEspecs();

    // consulta as especs da profissão no banco, caso a profissão não tenha sido adicionada
    if (profId !== "new" && profId !== "") {
        let profEspecs = await fetchGetEspecs(profId);

        if (profEspecs) {
            for (let espec of profEspecs) {
                let { idespec, dscespec } = espec;
                dscespec = capitalizeFirstLetter(dscespec);
                selectEspecsControl.addOption({
                    value: idespec,
                    text: dscespec,
                });
            }
            selectEspecsControl.refreshOptions();
        }
    }
};

// adiciona a especialização
confirmBtn.onclick = async () => {
    let profId = selectProf.value;
    let dscProf = selectProfsControl.getItem(profId).innerText;
    let especId = selectEspec.value;
    let dscEspec = selectEspecsControl.getItem(especId).innerText;

    await fetchAddEspec(profId, dscProf, especId, dscEspec);

    // if (profId && especId) {
    // } else {
    //     formErro("Selecione uma profissão e especialização");
    // }
};

async function fetchGetEspecs(profId) {
    // aborts previous fetch if it exists and creates a new one
    if (especsAbortControl) {
        especsAbortControl.abort();
    }
    especsAbortControl = new AbortController();

    loadingGetEspecs();
    try {
        let response = await fetch(`./php/post/profissao/getEspecs.php`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            signal: especsAbortControl.signal,
            body: `profId=${profId}`,
        });
        let data = await response.json();
        console.log(data);

        clearSelectEspecs();

        if (data.dados) {
            return data.dados;
        }
    } catch (error) {
        console.error(error);
    }
}

async function fetchAddEspec(profId, dscProf, especId, dscEspec) {
    // aborts previous fetch if it exists and creates a new one
    if (especsAbortControl) {
        especsAbortControl.abort();
    }
    especsAbortControl = new AbortController();

    try {
        let response = await fetch(`./php/post/user/adicionarEspec.php`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            signal: especsAbortControl.signal,
            body: `profId=${profId}&dscProf=${dscProf}&especId=${especId}&dscEspec=${dscEspec}`,
        });
        let data = await response.text();
        console.log(data);

        if (data.action) {
            setOpenToast(
                "#notifyToast",
                "Modificação de Profissões",
                "Sua profissão foi adicionada com sucesso"
            );
            window.location.reload();
        }
    } catch (error) {
        console.error(error);
    }
}

/* ========== USER FEEDBACK ========== */

function loadingGetEspecs() {
    feedbackDiv.style.display = "block";
    feedbackDiv.style.backgroundColor = "#026773";
    feedbackDiv.innerText = "Aguarde um momento...";

    // changes select placeholder
    selectEspecsControl.settings.placeholder = "Aguarde um momento...";
    selectEspecsControl.inputState();
}

function clearSelectEspecs() {
    feedbackDiv.style.display = "none";

    selectEspecsControl.clear();
    selectEspecsControl.clearOptions();

    let profId = selectProf.value;
    if (profId) {
        let profissao = selectProfsControl.getItem(profId).innerText;
        selectEspecsControl.settings.placeholder = `Selecione uma especialização de ${profissao}`;
        selectEspecsControl.inputState();
    }
}

function formErro(textErro) {
    feedbackDiv.style.display = "block";
    feedbackDiv.style.backgroundColor = "#cf1c0e";
    feedbackDiv.innerText = textErro;
}

// function loading() {
//     // loading spinner
//     if (!document.querySelector("#loading")) {
//         let containerDiv = document.createElement("div");
//         containerDiv.classList.add("d-flex", "justify-content-center");
//         containerDiv.setAttribute("id", "containerLoading");

//         let ldsRing = document.createElement("div");
//         ldsRing.classList.add("lds-ellipsis");

//         ldsRing.append(document.createElement("div"));
//         ldsRing.append(document.createElement("div"));
//         ldsRing.append(document.createElement("div"));
//         ldsRing.append(document.createElement("div"));

//         containerDiv.append(ldsRing);
//         modalBody.append(containerDiv);
//     }

//     // changes select placeholder
//     selectEspecsControl.settings.placeholder = "Aguarde um momento...";
//     selectEspecsControl.inputState();
// }
// function clearLoading() {
//     // removes loading spinner
//     document.querySelector("#containerLoading").remove();

//     // changes select placeholder again
//     selectEspecsControl.clear();
//     selectEspecsControl.clearOptions();
//     let profissao = selectProfsControl.getItem(selectProf.value).innerText;
//     selectEspecsControl.settings.placeholder = `Selecione uma especialização de ${profissao}`;
//     selectEspecsControl.inputState();
// }

/* ========== SEARCHBALE SELECTS ========== */

// SELECT ADD PROFISSAO
let selectProfsControl = new TomSelect("#addProf", {
    persist: false,
    create: function (input) {
        return { value: "new", text: input };
    },
    sortField: {
        field: "text",
        direction: "asc",
    },
    render: {
        option_create: function (data, escape) {
            return (
                '<div class="create">Adicionar <strong>' +
                escape(data.input) +
                "</strong>&hellip;</div>"
            );
        },
        no_results: function (data, escape) {
            return (
                '<div class="no-results">Nenhum resultado encontrado para "' +
                escape(data.input) +
                '"</div>'
            );
        },
    },
});

// SELECT ADD ESPECIALIZACAO
let selectEspecsControl = new TomSelect("#addEspec", {
    persist: false,
    create: function (input) {
        return { value: "new", text: input };
    },
    sortField: {
        field: "text",
        direction: "asc",
    },
    render: {
        option_create: function (data, escape) {
            return (
                '<div class="create">Adicionar <strong>' +
                escape(data.input) +
                "</strong>&hellip;</div>"
            );
        },
        no_results: function (data, escape) {
            return (
                '<div class="no-results">Nenhum resultado encontrado para "' +
                escape(data.input) +
                '"</div>'
            );
        },
    },
});

function deleteEspec() {}
