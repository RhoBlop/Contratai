<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?php require("components/head.php") ?>
        <link rel="stylesheet" href="css/chaThiago.css">
    </head>
    <body>
        <?php include ("components/header-auth.php") ?>

        <main>
        <div class="container p-3 my-3">
                <div class="row gx-5 justify-content-center">

                    <!-- REVIEW Deixar o template da tabela pronto para depois preenchê-la. -->
                    <div class="col-10 px-4 flex-column">

                        <div class="mb-4 text-center">
                            <h2>Administração do sistema</h2>
                        </div>
                
                            <label for="prof" class="form-label">Profissão</label>
                            <select name="profissao" id="prof">
                                <option value="" selected>Selecione uma profissão</option>
                                <?php 
                                    $profissaoClass = new Profissao();
                                    $profissoes = $profissaoClass->selectAll()["dados"];

                                    foreach ($profissoes as $prof):

                                        [$idprof, $descrprof] = [$prof['idprof'], ucfirst($prof['descrprof'])];

                                        echo <<<HTML
                                        <option value="{$idprof}">{$descrprof}</option>
                                        HTML;
                                        
                                    endforeach;
                                ?>
                                
                            </select>

                            <form id="updateProf"></form>
                    </div>
                </div>
            </div>
        </main>
    </body>

    
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script> 
        let selectProfs = document.querySelector("#prof");
        let formProf = document.querySelector("#updateProf");

        selectProfs.onchange = async () => {
            let profid = selectProfs.value; 
            
            if (profid !== "") {
                let profInfos = await fetchGetProf(profid);
                let { idprof, descrprof, imgprof } = profInfos[0];
                
                fillProfForm(idprof, descrprof, imgprof);
            } else {
                formProf.innerHTML = "";
            }
        }

        async function fetchGetProf(profId) {
            formProf.innerHTML = "";
            try {
                let response = await fetch(`./php/post/profissao/getProf.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `profId=${profId}`,
                });
                let data = await response.json();
                console.log(data);
                
                if (data.dados) {
                    return data.dados;
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function sendUpdateProfissao(event, idProf) {
            event.preventDefault();

            let formData = new FormData(event.target);
            formData.append("idProf", idProf);

            try {
                let response = await fetch(`./php/post/profissao/updateProf.php`, {
                    method: "POST",
                    credentials: "same-origin",
                    body: formData,
                });
                let data = await response.text();
                console.log(data);
                
                if (data.dados) {
                    return data.dados;
                }
            } catch (error) {
                console.error(error);
            }
        }

        function fillProfForm(idProf, descrProf, imgProf) {
            formProf.onsubmit = (event) => {
                sendUpdateProfissao(event, idProf);
            }
            const imgInput = createImgInput(imgProf);
            const profInput = createProfInput(descrProf);
            const submitBtn = createSubmitButton();

            formProf.append(profInput);
            formProf.append(imgInput);
            formProf.append(submitBtn);
        }

        function createImgInput(imgSrc) {
            const input = document.createElement('div');
            input.innerHTML = `
                <label id="inputFileLabel" for="inputImg" class="rounded-circle mb-4">
                    <img src="${imgSrc || "images/temp/default-pic.png"}" id="imgPerfil" alt="">
                    <div class="editar-hover">
                        <i class="fa-solid fa-pen"></i>
                        <p>Editar Foto</p>
                    </div>
                </label>
                <input id="inputImg" type="file" name="imgProf" onchange="showSelectedImg(event, '#imgPerfil')">`
            return input;
        }
        function createProfInput(descrProf) {
            const input = document.createElement("input");
            setAttributes(input, {
                "class": "form-control",
                "type": "text",
                "name": "descrProf"
            })
            input.value = descrProf;

            return input;
        }
        function createSubmitButton() {
            const btn = document.createElement("button");
            setAttributes(btn, {
                'type': 'submit',
                'class': 'btn btn-green'
            });
            btn.innerHTML = "Atualizar";

            return btn;
        }
    </script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>