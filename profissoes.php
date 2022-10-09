<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/auth-header.php") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">
                    <?php include("components/modal-addProf.php")?>

                    <?php include("components/sidebar.php")?>

                    <div class="col-md-8 px-3" id="settingsContent">
                        <div class="mb-4">
                            <h2>Profissões</h2>
                            <h6 class="text-muted">Veja e adicione suas Profissões</h6>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-8 d-flex flex-column justify-content-center">
                                <?php
                                    $usuarioClass = new Usuario();

                                    $profissoes = $usuarioClass->selectProfissoessById($_SESSION["idusr"]);

                                    foreach($profissoes as $prof):

                                        [$idusres, $dscespec, $dscprof] = [$prof["idusrespec"], ucfirst($prof["dscespec"]), ucfirst($prof["dscprof"])];
                                ?>

                                    <!-- CARD PROFISSÃO -->
                                    <div class="card shadow-sm rounded-4 my-3" id="cardProfissao">
                                        <div class="card-body d-flex justify-content-between align-items-center px-4">

                                            <div class="card-text">
                                                <h5 class="mb-0"><?php echo $dscprof ?></h5>
                                                <p class="text-muted"><?php echo $dscespec ?></p>
                                            </div>

                                            <a href="<?php echo '?idexclude={$idusres}' ?>" class="exclude">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>

                                        </div>
                                    </div>

                                <?php 
                                    endforeach;
                                ?>

                                <div class="mt-3 text-center">
                                    <a data-bs-toggle="modal" data-bs-target="#modal-addProf" class="btn btn-link">Adicionar profissão</a>
                                </div>
                                
                            </div>
                        </div>
                        
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