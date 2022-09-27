// controller for aborting http requests
let abortControl = null;

let form = searchBox.form;
let searchBox = form.querySelector("#searchBox");
let searchResult = document.querySelector("#searchResult");

// DISPLAY FILTERS UNDER SEARCH BAR WHEN THE PREVIOUS IS CLICKED
searchBox.onclick = () => {
    form.classList.add("active");
}

/* ========== EVENTS FOR ACTIVATING SEARCHS ========== */
// CHANGE EVENT FOR FILTERS
for (input of document.querySelectorAll(".search-filter")) {
    input.onchange = () => {
        search(form);
    }
}
// ENTER PRESSED WHEN IN SEARCHBAR
searchBox.onkeyup = (event) => {
    if (event.keyCode == 13) {
        search(form);
    }
};
// SEARCHBAR LOSES FOCUS
searchBox.onchange = (event) => {
    search(form);
}


// AJAX SEARCH FUNCTION
async function search() {
    // aborts previous fetch if it exists and creates a new one
    if (abortControl) {
        abortControl.abort();
    }
    abortControl = new AbortController();

    
    if (searchBox.value !== "") {
        let formData = new URLSearchParams(new FormData(form)).toString();
        console.log(formData);

        loading();
        
        try {
            console.log("new request being made");
            let response = await fetch("./API/pesquisa.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                signal: abortControl.signal,
                body: formData
            });
            let data = await response.json();
            console.log(data);
            
            let { dados } = data;
            if (dados) {
                clearLoading();
                constructSearchCards(dados);
            } else {
                // Error message
            }
        } catch (error) {
            console.error(error);
        }
    }
}

function loading() {
    // inserts loading spinner into div
    // spinner structure => <div class="lds-ring"> <div></div> <div></div> <div></div> </div>
    let ldsRing = document.createElement("div");
    ldsRing.setAttribute("id", "loading");
    ldsRing.classList.add("lds-ring");
    for (i=0; i<3; i++) {
        ldsRing.append(document.createElement("div"));
    }


    searchResult.prependChild(ldsRing);
}

function clearLoading() {
    // selects loading spinner and deletes it
    document.querySelector("#loading").remove();
}

function constructSearchCards(dados) {
    let searchResult = document.querySelector("#cardsPesquisa");
    searchResult.innerHTML = '';

    for (info of dados) {
            let profCard = createProfCard(info);
            searchResult.append(profCard);
    }
}

function createProfCard() {
    let card = document.createElement("div");
    card.classList.add("card", "card-hover", "card-pesquisa");
    card.innerHTML = `
        <img src="${info.imgusr}" alt="Imagem de perfil">
        <div class="card-body">
            <div class="card-title">
                <h5>${info.nomusr}</h5>
                <span class="badge-avaliacao">
                    <!-- STAR ICON -->
                    <ion-icon name="star"></ion-icon>
                    ${info.mediaAv}
                </span>
            </div>
            <div class="card-text">
                <p>Total de ${info.numcontrato} contratações como ${info.dscprof}</p>

                <p>Em nossa plataforma desde</p>

                <a href="perfil-publico.php?id=${info.idusr}"><span class="clickable-card"></span></a>
            </div>
        </div>`;
    
    return card;
}