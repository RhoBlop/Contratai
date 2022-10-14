<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php 
            if ($auth) {
                include("components/auth-header.php");
            } else {
                include("components/no-auth-header.php");
            }
        ?>

        <main>
            <?php 
                $profissaoClass = new Profissao();
                $idprof = $_GET["id"];
                
                $users = $profissaoClass->selectProfissaoMaiorAvaliacao($idprof, $limit = 8);
                if ($users):
                    $descrprof = $users[0]["descrprof"];
            ?>

                <div class="container p-3 my-3 align-items-center">
                    <div class="mb-4">
                        <h2><?php echo ucfirst($descrprof) ?></h2>
                        <h6 class="text-muted">Encontre os melhores profissionais em nossa plataforma</h6>
                    </div>

                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <?php 
                            foreach($users as $user) {
                                [$iduser, $nomeuser, $imguser, $numcontrato, $mediaAv, $datacriacaouser] = [$user["iduser"], $user["nomeuser"], $user["imguser"], $user["numcontrato"], $user["mediaavaliacao"], $user["datacriacaouser"]];
                        
                                include ("components/card-pesquisa-profissao.php");
                            }
                        ?>
                    </div>
                </div>
            <?php
                else:
            ?>
                <div>
                    Nenhum usuário cadastrado nessa profissão
                </div>
            <?php
                endif;
            ?>
        </main>

    </body>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>