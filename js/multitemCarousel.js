let carousels = document.querySelectorAll(".multitem-car");

for (let carousel of carousels) {
    // .active no primeiro carousel-item
    carousel.querySelector(".carousel-item").classList.add("active");

    if (window.matchMedia("(min-width: 768px)").matches) {
        // desativa autoplay do carrosel
        const carouselBoot = new bootstrap.Carousel(carousel, {
            interval: false
        });


        // número de cards no carrosel
        let itemNumbers = 4;
        let carouselInner = carousel.querySelector(".carousel-inner")
        // largura total do carrosel, contando também com o conteúdo em overflow
        let carouselWidth = carouselInner.scrollWidth;
        // largura do card
        let cardWidth = carousel.querySelector(".carousel-item").offsetWidth;
    
        // posição do scroll na div do carrosel - serve para movimentar os itens
        let scrollPosition = 0;
    
        let nextItemControl = carousel.querySelector(".carousel-control-next")
        nextItemControl.addEventListener("click", () => {
            scrollPosition = scrollPosition + cardWidth;
            let maxPosition = carouselWidth - (cardWidth * itemNumbers);
            if (scrollPosition > maxPosition) {
                scrollPosition = 0;
            }
            carouselInner.scroll({
                left: scrollPosition,
                behavior: "smooth"
            })
        })
    
        let prevItemControl = carousel.querySelector(".carousel-control-prev");
        prevItemControl.addEventListener("click", () => {
            scrollPosition = scrollPosition - cardWidth;
            let maxPosition = carouselWidth - (cardWidth * 3);
            if (scrollPosition < 0) {
                scrollPosition = maxPosition;
            }
            carouselInner.scroll({
                left: scrollPosition,
                behavior: "smooth"
            })
        })
    } else {
        carousel.classList.add("slide");
    }
}