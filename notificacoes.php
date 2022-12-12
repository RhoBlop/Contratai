<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/header-auth.php") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">
                    <?php include("components/sidebar.php")?>

                    <div class="col-10 px-4 d-flex flex-column" id="settingsContent">
                        <div class="mb-4">
                            <h2>Minhas notificações</h2>
                            <h6 class="text-muted">Veja as notificações de seus contratos</h6>
                        </div>

                        <div class="row d-flex flex-column align-items-center">
                            
                            <div class="nav nav-justified filter-tablist rounded-3 mb-3" id="tablist" role="tablist">
                                <a class="nav-link active" id="naoVisualizado-tab" data-bs-toggle="tab" type="button" data-bs-target="#naoVisualizado-pane" role="tab">Não visualizado</a>
                                <a class="nav-link" id="visualizado-tab" data-bs-toggle="tab" type="button" data-bs-target="#visualizado-pane" role="tab">Visualizado</a>
                            </div>

                            <?php
                                include ("components/card-notificacao.php");
                                [$naoVisualizado, $visualizado] = $usuarioClass->selectNotificacoes($_SESSION["iduser"]);
                            ?>

                            <div class="tab-content col-8 d-flex flex-column justify-content-center">
                                <div id="naoVisualizado-pane" class="tab-pane fade show active">
                                    <?php

                                        if (count($naoVisualizado) < 1) {
                                            echo constructEmptyCard();
                                        } else {
                                            foreach ($naoVisualizado as $notific):
                                                echo constructNotificacaoCard($notific['idnotific'], $notific["title"], $notific["text"], $notific["descrcontrato"], $notific["timecriacao"]);
                                            endforeach;
                                        }

                                    ?>
                                </div>

                                <div id="visualizado-pane" class="tab-pane fade">
                                    <?php

                                        if (count($visualizado) < 1) {
                                            echo constructEmptyCard();
                                        } else {
                                            foreach ($visualizado as $notific):
                                                echo constructNotificacaoCard($notific['idnotific'], $notific["title"], $notific["text"], $notific["descrcontrato"], $notific["timecriacao"]);
                                            endforeach;
                                        }
                                    ?>
                                </div>
                            <div>
                        <div>
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
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>