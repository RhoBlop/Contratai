<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script>
        async function sendImg(event) {
            event.preventDefault();
            
            let formData = new FormData(event.target);
            let response = await fetch("./teste.php", {
                method: "POST",
                headers: {
                    "Accept": "application/json"
                },
                body: formData
            });

            let data = await response.text();

            console.log(data);
        }
    </script>
</head>
<body>
    <form onsubmit="sendImg(event)">
        <div>
            <label for="nome">Nome do usuário</label>
            <input type="text" id="nome" name="nome" placeholder="Nome">
        </div>

        <input type="file" name="imgUsr">
        <button type="submit">Clicar</button>
    </form>
</body>
</html>