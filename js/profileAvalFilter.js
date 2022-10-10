window.addEventListener("DOMContentLoaded", (event) => {
    let filters = document.querySelectorAll(".search-filter");
    let headerAvaliacoes = document.querySelector("#notaAvaliacoes");
    
    for (filter of filters) {
        filter.onchange = (event) => {
            let avaliacoes = document.querySelectorAll(".avaliacao");
            if (avaliacoes) {
                let filterId = event.target.value;
                let numAvals = 0;
                let somaNotaAvals = 0;

                for (aval of avaliacoes) {
                    let avalId = aval.dataset.especid;
                    let notaAval = parseInt(aval.dataset.nota);
                    console.log(notaAval);
                    if (filterId === "todos") {
                        aval.style.display = "block";

                        somaNotaAvals += notaAval;
                        numAvals++;
                    } else if (filterId === avalId) {
                        aval.style.display = "block";

                        somaNotaAvals += notaAval;
                        numAvals++;
                    } else {
                        aval.style.display = "none";
                    }
                }

                let mediaAvals = somaNotaAvals === 0 ? "0.0" : (somaNotaAvals/numAvals).toFixed(1);

                if (numAvals === 0) {
                    headerAvaliacoes.innerText = `Nenhuma avaliação dessa especialização`;
                } else {
                    headerAvaliacoes.innerText = `${mediaAvals} de ${numAvals} avaliações`;
                }
            }
        }
    }
});