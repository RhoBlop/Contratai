<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php 
            if ($auth) {
                include("components/login-header.php");
            } else {
                include("components/home-header.html");
            }
        ?>

        <main>
            <?php 
                $idprof = $_GET["id"];
                $users = $profissaoClass->selectAnunciosMaiorAvaliacao($idprof, $limit = 8);
                $dscprof = $users[0]["dscprof"];
            ?>

            <div class="container p-3 my-3 align-items-center">
                <div class="mb-4">
                    <h2><?php echo ucfirst($dscprof) ?></h2>
                    <h6 class="text-muted">Encontre os melhores profissionais em nossa plataforma</h6>
                </div>

                <div class="d-flex justify-content-center align-items-center flex-column">
                    <?php 
                        foreach($users as $user):
                            [$idusr, $nomusr, $imgusr, $numcontrato, $mediaAv] = [$user["idusr"], $user["nomusr"], $user["imgusr"], $user["numcontrato"], $user["mediaavaliacao"]];
                    ?>

                        <div class="card card-hover card-pesquisa">
                            <img src="<?php echo echoProfileImage($imgusr) ?>" alt="Imagem de perfil">
                            <div class="card-body">
                                <div class="card-title">
                                    <h5><?php echo $nomusr; ?></h5>
                                    <span class="badge-avaliacao <?php echo echoAvaliacaoClass($mediaAv); ?>">
                                        <!-- STAR ICON -->
                                        <ion-icon name="star"></ion-icon>
                                        <?php echo $mediaAv; ?>
                                    </span>
                                </div>
                                <div class="card-text">
                                    <p>Total de <?php echo $numcontrato; ?> contratações como <?php echo $dscprof ?></p>

                                    <p>Em nossa plataforma desde <?php echo "[atualizar banco de dados]" ?></p>

                                    <a href="<?php echo "perfil-publico.php?id={$idusr}" ?>"><span class="clickable-card"></span></a>
                                </div>
                            </div>
                        </div>

                    <?php 
                        endforeach;
                    ?>
                </div>
            </div>
        </main>

        <?php include ("components/footer.html")?>
    </body>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>