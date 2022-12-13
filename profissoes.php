<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/header-auth.php") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">
                    <?php include("components/modal-addProf.php")?>

                    <?php include("components/sidebar.php")?>

                    <div class="col-10 px-4" id="settingsContent">
                        <div class="mb-4">
                            <h2>Minhas profissões</h2>
                            <h6 class="text-muted">Veja e adicione suas profissões disponíveis publicamente</h6>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-6 d-flex flex-column justify-content-center">
                                <?php
                                    $usuarioClass = new Usuario();

                                    $profissoes = $usuarioClass->selectProfissoessById($_SESSION["iduser"]);

                                    foreach($profissoes as $prof):

                                        [$iduseres, $idespec, $descrespec, $descrprof] = [$prof["iduserespec"], $prof["idespec"], ucfirst($prof["descrespec"]), ucfirst($prof["descrprof"])];
                                ?>

                                    <!-- CARD PROFISSÃO -->
                                    <div class="card card-profissao shadow-sm rounded-4 my-3">
                                        <div class="card-body d-flex justify-content-between align-items-center px-4">

                                            <div class="card-text">
                                                <h5 class="mb-0"><?php echo $descrprof ?></h5>
                                                <p class="text-muted"><?php echo $descrespec ?></p>
                                            </div>

                                            <button class="exclude" onclick="deleteEspec(event)" data-especid="<?php echo $idespec ?>">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>

                                        </div>
                                    </div>

                                <?php 
                                    endforeach;
                                ?>

                                <div class="mt-3 text-center">
                                    <a data-bs-toggle="modal" data-bs-target="#modaladdProf" class="btn btn-link">Adicionar profissão</a>
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

    <script>
        checkForOpenToast();
    </script>
</html>