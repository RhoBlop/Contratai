function showSelectedImg(event, idImg) {
    let input = event.target;
    
    if (input.files.length === 1) {
        // pega o arquivo selecionado pelo input
        let file = input.files[0];

        let reader = new FileReader();
        // ler a imagem binária em formato de dataURL (base64)
        reader.readAsDataURL(file);

        reader.onload = function(e) {
            // quando um arquivo for lido, colocar o base64 na imagem com id passada por parâmetro
            document.querySelector(`${idImg}`).src = e.target.result;
        }
    }

}