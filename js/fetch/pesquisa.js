// controller for aborting http requests
let searchAbortControl = null;

let searchBox = document.querySelector("#searchBox");
let searchButton = document.querySelector("#searchButton");
let searchResult = document.querySelector("#searchResult");
let form = searchBox.form;
let filterTable;

// pagination
let itemsNumToBeDisplayed = 2;
let offset = 0;

/* ========== EVENTS FOR ACTIVATING SEARCHS ========== */

// change event for filters
for (input of document.querySelectorAll(".search-filter")) {
    input.onchange = () => {
        searchResult.innerHTML = "";
        offset = 0;
        search();
    };
}

searchBox.onclick = () => {
    form.classList.add("active");
}

// search button clicked
searchButton.onclick = () => {
    searchResult.innerHTML = "";
    offset = 0;
    search();
};

/* ========== API SEARCH ========== */

// executes fetch function and deals with data returned
async function search() {
    if (searchBox.value !== "") {
        let data = await ajaxSearch();

        if (data) {
            if (data.dados) {
                let { dados } = data;
                console.log(dados);

                constructSearchCards(dados);
            } else {
                let { erro } = data;
                searchResult.innerHTML = erro;
            }
        }
    }
}

// fetch function
async function ajaxSearch() {
    // aborts previous fetch if it exists and creates a new one
    if (searchAbortControl) {
        searchAbortControl.abort();
    }
    searchAbortControl = new AbortController();

    // only 8 will be displayed, but searches for +1 to check if we can search again
    let limit = itemsNumToBeDisplayed + 1;

    // converts formData to x-www-form-urlencoded
    formData = new FormData(form);
    filterTable = formData.get("filterTable");

    loading();
    try {
        let response = await fetch(
            `./php/post/pesquisa.php?limit=${limit}&offset=${offset}`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                signal: searchAbortControl.signal,
                body: new URLSearchParams(formData).toString(),
            }
        );
        let data = await response.json();

        clearLoading();

        return data;
    } catch (error) {
        console.error(error);
    }
}

/* ========== SEARCH ITEMS CONSTRUCTION ========== */

// responsible for building and appending cards based on search results into the DOM
function constructSearchCards(dados) {
    if (dados.length > 0) {
        for (let i = 0; i < dados.length && i < itemsNumToBeDisplayed; i++) {
            let object = dados[i];
            let searchCard;
            if (filterTable === "profissao") {
                searchCard = createProfCard(object);
            } else if (filterTable === "usuario") {
                searchCard = createUserCard(object);
            }
            searchCard.style.animationDelay = `${i * 0.2}s`;

            searchResult.append(searchCard);
        }

        // in case one item above itemsToBeDisplayed has returned from search, the user can add more items to search
        if (dados.length === itemsNumToBeDisplayed + 1) {
            addContinueSearch();
        }
    } else {
        searchResult.innerHTML = "Nenhum usu??rio encontrado";
    }
}

function createProfCard(prof) {
    let card = document.createElement("div");
    card.classList.add("card", "card-hover", "card-pesquisa", "py-1");
    let {
        idprof,
        imgprof,
        especsprof,
        descrprof,
        mediaavaliacao
    } = prof;

    card.innerHTML = `
        <div class="search-profile-pic ps-3">
            <img src="${
                imgprof || "images/temp/default-pic.png"
            }" alt="Imagem de perfil">
        </div>
        <div class="card-body">
            <div class="card-title">
                <h6>${capitalizeFirstLetter(descrprof)}</h6>
                <span class="badge-avaliacao ${
                    mediaavaliacao > 4.5 ? "avaliacao-otima" : "avaliacao-media"
                }">
                    <!-- STAR ICON -->
                    <ion-icon name="star"></ion-icon>
                    ${mediaavaliacao == null ? "---" : mediaavaliacao}
                </span>
            </div>
            <div class="card-text">
                <p class="mb-1">Especializa????es:</p>
                <div class="contract-dates">
                        ${(function generateEspecChips(especs){
                            let string = "";
                            for (espec of especs) {
                                string += `<div class="date-chip">${capitalizeFirstLetter(espec)}</div>`;
                            }
                            return string;
                        })(especsprof)}
                </div>

                <a href="profissao.php?id=${idprof}"><span class="clickable-card"></span></a>
            </div>
        </div>`;

    return card;
}

// returns DOM element for a user card
function createUserCard(user) {
    let card = document.createElement("div");
    card.classList.add("card", "card-hover", "card-pesquisa");
    let {
        iduser,
        imguser,
        nomeuser,
        mediaavaliacao,
        numcontrato,
        especsuser,
        datacriacaouser,
    } = user;

    datacriacaouser = dayjs(datacriacaouser)
        .locale("pt-br")
        .format("D [de] MMMM [de] YYYY");

    // join specs onto string
    especsuser = especsuser.join(", ");
    // capitalize string first letter
    especsuser = capitalizeFirstLetter(especsuser);

    card.innerHTML = `
        <div class="search-profile-pic ps-3">
            <img src="${
                imguser || "images/temp/default-pic.png"
            }" alt="Imagem de perfil">
        </div>
        <div class="card-body">
            <div class="card-title">
                <h6>${nomeuser}</h6>
                <span class="badge-avaliacao ${
                    mediaavaliacao > 4.5 ? "avaliacao-otima" : "avaliacao-media"
                }">
                    <!-- STAR ICON -->
                    <ion-icon name="star"></ion-icon>
                    ${mediaavaliacao == null ? "---" : mediaavaliacao}
                </span>
            </div>
            <div class="card-text">
                <h8>${
                    numcontrato > 0
                        ? `Total de ${numcontrato} contrata????es`
                        : `Ainda n??o foi contratado nenhuma vez`
                }</h8>
                <p class="text-muted">${especsuser}</p>

                <p class="text-muted">Em nossa plataforma desde ${datacriacaouser}</p>

                <a href="perfil-publico.php?id=${iduser}"><span class="clickable-card"></span></a>
            </div>
        </div>`;

    return card;
}

/* ========== USER FEEDBACK ========== */

// adds loading spinner while search is pendent
function loading() {
    searchResult.classList.add("show-result");

    // inserts loading spinner into div
    // spinner structure => <div class="lds-ring"> <div></div> <div></div> <div></div> </div>
    if (!document.querySelector("#loading")) {
        let ldsRing = document.createElement("div");
        ldsRing.setAttribute("id", "loading");
        ldsRing.classList.add("lds-ellipsis");

        ldsRing.append(document.createElement("div"));
        ldsRing.append(document.createElement("div"));
        ldsRing.append(document.createElement("div"));
        ldsRing.append(document.createElement("div"));

        searchResult.append(ldsRing);
    }
}
// deletes loading spinner when search is completed
function clearLoading() {
    // selects loading spinner and deletes it
    document.querySelector("#loading").remove();
}

// adds arrow that, when clicked, searchs for more items (pagination)
function addContinueSearch() {
    let button = document.createElement("button");
    button.classList.add("btn", "btn-continue-search");
    button.onclick = () => {
        // adds to offset value
        offset += itemsNumToBeDisplayed;
        // removes button
        button.remove();
        // starts loading and search
        search();
    };

    let arrowIcon = document.createElement("i");
    arrowIcon.classList.add("fa-solid", "fa-angle-down");

    button.append(arrowIcon);
    searchResult.append(button);
}
