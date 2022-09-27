// controller for aborting http requests
let abortControl = null;

let searchBox = document.querySelector("#searchBox");
let form = searchBox.form;
let searchResult = document.querySelector("#searchResult");
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
        search(form);
    }
}
// ENTER PRESSED WHEN IN SEARCHBAR
searchBox.onkeyup = (event) => {
    if (event.keyCode == 13) {
        searchResult.innerHTML = "";
        search(form);
    }
};
// SEARCHBAR LOSES FOCUS
searchBox.onchange = (event) => {
    searchResult.innerHTML = "";
    search(form);
}


// AJAX SEARCH FUNCTION
async function search() {
    if (searchBox.value !== "") {
        let data = await searchRequest();
    }
            
    let { dados } = data;
    if (dados) {
        clearLoading();
        constructSearchCards(dados);
    } else {
        let { erro } = data;
        searchResult.innerHTML = erro;
    }
}

async function searchRequest() {
    // aborts previous fetch if it exists and creates a new one
    if (abortControl) {
        abortControl.abort();
    }
    abortControl = new AbortController();

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

        return data;
    } catch (error) {
        console.error(error);
    }
}

function checkIfFirstQuery() {
    
}

function loading() {
    searchResult.style.display = "flex";

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

function addPlusButton() {

}

function constructSearchCards(dados) {
    console.log(dados);
    if (dados.length > 0) {
        for (info of dados) {
                let profCard = createUserCard(info);
                searchResult.append(profCard);
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
    especs = JSON.parse(info.especsusr);
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