<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
        <script src="js/requisicoesAPI.js"></script>
        <script src="js/selecionarImg.js"></script>
    </head>
    <body>
        <?php include ("components/login-header.php") ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">
                    <?php include("components/modal-addProf.php")?>

                    <?php include("components/sidebar.html")?>

                    <div class="col-md-8 px-3" id="settingsContent">
                        <div class="mb-4">
                            <h2>Profissões</h2>
                            <h6 class="text-muted">Veja e adicione suas Profissões</h6>
                        </div>

                        <div class="row">
                            <div class="col-7 d-flex flex-column justify-content-center">
                                <div class="card shadow-sm rounded-4 my-3" id="cardProfissao">
                                    <div class="card-body d-flex justify-content-between align-items-center px-4">

                                        <div class="card-text">
                                            <h5 class="mb-0">Designer</h5>
                                            <p class="text-muted">Designer Gráfico</p>
                                        </div>

                                        <button type="button" class="btn-close" aria-label="Close"></button>

                                    </div>
                                </div>

                           
                                <a data-bs-toggle="modal" data-bs-target="#modal-addProf" class="btn btn-link">Adicionar profissão</a>
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