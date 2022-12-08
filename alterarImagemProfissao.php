<!DOCTYPE html>
<html lang="en" class="hydrated">
    <head>
        <?php require("components/head.php") ?>
        <link rel="stylesheet" href="css/chaThiago.css">
    </head>
    <body>
        <?php include ("components/header-auth.php") ?>

        <input type="hidden" id="userId" value="<?php echo $_SESSION["iduser"]; ?>">

        <main>
            <div class="container">
                <h3 class="my-3">Sim, fiz uma página para adicionar/alterar as imagens das profissões.</h3>


                <form onsubmit="sendUpdateProfissão(event)">
                    <div class="form-group mb-3">
                        <label for="especializacao" class="form-label">Profissão</label>
                        <select name="profissao" id="prof">
                            <option value="" selected>Selecione uma profissão</option>
                            <?php 
                            $profissaoClass = new Profissao();
                            $profissoes = $profissaoClass->selectAll()["dados"];

                            foreach ($profissoes as $prof):

                                [$idprof, $descrprof] = [$prof['idprof'], ucfirst($prof['descrprof'])];

                                echo <<<ITEM
                                <option value="{$idprof}">{$descrprof}</option>
                                ITEM;
                                
                            endforeach;
                            ?>

                            
                        </select>
                    </div>
                </form>
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

        selectProfs.onchange = async () => {
            let profid = selectProfs.value; 
            
            if (profid !== "") {
                let profInfos = await fetchGetProf(profid);
                let img = profInfos[0]['imgprof'];

            }
        }

        async function fetchGetProf(profId) {
            try {
                let response = await fetch(`./php/post/profissao/getProf.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: `profId=${profId}`,
                });
                let data = await response.json();
                
                if (data.dados) {
                    return data.dados;
                }
            } catch (error) {
                console.error(error);
            }
        }
    </script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>