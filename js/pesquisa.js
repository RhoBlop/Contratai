let abortControl = null;

let searchBox = document.querySelector("#searchBox");
let form = searchBox.form;
console.log(form);

searchBox.onclick = () => {
    form.classList.add("active");
}

// sempre que um dos checkboxes soferem alteração, o request ao servidor é refeito
for (input of document.querySelectorAll(".search-filter")) {
    input.onchange = () => {
        search(form);
    }
}
// pesquisa quando enter é pressionado na barra de pesquisa
searchBox.onkeyup = (event) => {
    if (event.keyCode == 13) {
        search(form);
    }
};
searchBox.onchange = (event) => {
    search(form);
}


async function search() {
    if (abortControl) {
        abortControl.abort();
    }
    abortControl = new AbortController();
    let formData = new URLSearchParams(new FormData(form)).toString();
    console.log(formData);

    if (searchBox.value !== "") {
        document.querySelector("#searchResult").style.display = "flex";
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
            }
        } catch (error) {
            console.error(error);
        }
    }
}

function loading() {
    document.querySelector("#searchResult .lds-ring").style.display = "inline-block";
}
function clearLoading() {
    document.querySelector("#searchResult .lds-ring").style.display = "none";
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