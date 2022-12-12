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

                    <div class="col-10 px-4 flex-column" id="settingsContent">
                        <div class="mb-4">
                            <h2>Minhas notificações</h2>
                            <h6 class="text-muted">Veja as notificações de seus contratos</h6>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-8 d-flex flex-column justify-content-center">
                                <?php
                                    $notificacaoes = $usuarioClass->selectNotificacoes($_SESSION["iduser"]);
                                    foreach ($notificacaoes as $notific):
                                ?>

                                    <div class="card card-profissao shadow-sm rounded-4 my-3">
                                        <div class="card-body d-flex justify-content-between align-items-center px-4">

                                            <div class="card-text pe-4">
                                                <h5 class="mb-0"><?php echo $notific["title"] ?></h5>
                                                <p class="text-muted"><?php echo $notific["text"] ?></p>
                                            </div>

                                            <div class="time exclude">
                                                <p><?php echo timeElapsedString($notific["timecriacao"]) ?></p>
                                            </div>

                                        </div>

                                        <a class="stretched-link" href="contratos.php">
                                    </div>

                                <?php
                                    endforeach;
                                ?>
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