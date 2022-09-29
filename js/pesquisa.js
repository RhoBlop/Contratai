// controller for aborting http requests
let abortControl = null;

let searchBox = document.querySelector("#searchBox");
let searchButton = document.querySelector("#searchButton");
let searchResult = document.querySelector("#searchResult");
let form = searchBox.form;

let itemsNumToBeDisplayed = 1;
let hasMoreRows = true;
let offset = 0;

// DISPLAY FILTERS UNDER SEARCH BAR WHEN THE PREVIOUS IS CLICKED
searchBox.onclick = () => {
    form.classList.add("active");
}

/* ========== EVENTS FOR ACTIVATING SEARCHS ========== */
// CHANGE EVENT FOR FILTERS
for (input of document.querySelectorAll(".search-filter")) {
    input.onchange = () => {
        searchResult.innerHTML = "";
        offset = 0;
        search();
    }
}
// BUTTON CLICK AND FURTHER ENTER PRESS WHEN INPUT IS FOCUSED
searchButton.onclick = () => {
    searchResult.innerHTML = "";
    offset = 0;
    search();
}


// AJAX SEARCH FUNCTION
async function search() {
    if (searchBox.value !== "") {
        let data = await ajaxSearch();

        if (data) {
            if (data.dados) {
                let { dados } = data;

                constructSearchCards(dados);
            } else {
                let { erro } = data;
                searchResult.innerHTML = erro;
            }
        }

    }
            
}

async function ajaxSearch() {
    // aborts previous fetch if it exists and creates a new one
    if (abortControl) {
        abortControl.abort();
    }
    abortControl = new AbortController();
    
    // only 8 will be displayed, but searches for +1 to check if we can search again
    let limit = itemsNumToBeDisplayed + 1;

    // converts formData to x-www-form-urlencoded
    formData = new URLSearchParams(new FormData(form)).toString();

    loading();
    try {
        console.log("new request being made");
        let response = await fetch(`./API/pesquisa.php?limit=${limit}&offset=${offset}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            signal: abortControl.signal,
            body: formData
        });
        let data = await response.json();
        console.log(data);

        clearLoading();

        return data;
    } catch (error) {
        console.error(error);
    }
}


function loading() {
    searchResult.classList.add("show-result");

    // inserts loading spinner into div
    // spinner structure => <div class="lds-ring"> <div></div> <div></div> <div></div> </div>
    if (!document.querySelector("#loading")) {
        let ldsRing = document.createElement("div");
        ldsRing.setAttribute("id", "loading");
        ldsRing.classList.add("lds-ring");

        ldsRing.append(document.createElement("div"));
        ldsRing.append(document.createElement("div"));
        ldsRing.append(document.createElement("div"));
        
        searchResult.append(ldsRing);
    }
}

function clearLoading() {
    // selects loading spinner and deletes it
    document.querySelector("#loading").remove();
}

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
    searchResult.append(button)
}

function constructSearchCards(dados) {
    if (dados.length > 0) {
        for (let i=0; i<dados.length && i<itemsNumToBeDisplayed; i++) {
            let object = dados[i];
            let profCard = createUserCard(object);

            searchResult.append(profCard);
        }

        // caso um item a mais tenha sido retornado do fetch, o usuário recebe a oportunidade 
        // de adicionar mais itens à pesquisa (paginação)
        if (dados.length === itemsNumToBeDisplayed + 1) {
            addContinueSearch();
        }
    } else {
        searchResult.innerHTML = "Nenhum usuário encontrado";
    }

}

function createUserCard(user) {
    let card = document.createElement("div");
    card.classList.add("card", "card-hover", "card-pesquisa");

    let { idusr, imgusr, nomusr, mediaavaliacao, numcontrato, especs} = user;

    // convert into array
    especs = JSON.parse(user.especsusr);
    // join into string
    especs = especs.join(", ");
    // capitalize first letter
    especs = especs[0].toUpperCase() + especs.slice(1);
    
    card.innerHTML = `
        <img src="${imgusr || 'images/temp/default-pic.png'}" alt="Imagem de perfil">
        <div class="card-body">
            <div class="card-title">
                <h5>${nomusr}</h5>
                <span class="badge-avaliacao ${ mediaavaliacao > 4.5 ? "avaliacao-otima" : "avaliacao-media"}">
                    <!-- STAR ICON -->
                    <ion-icon name="star"></ion-icon>
                    ${mediaavaliacao}
                </span>
            </div>
            <div class="card-text">
                <p>Total de ${numcontrato} contratações</p>
                <p>${especs}</p>

                <p>Em nossa plataforma desde</p>

                <a href="perfil-publico.php?id=${idusr}"><span class="clickable-card"></span></a>
            </div>
        </div>`;
    
    return card;
}