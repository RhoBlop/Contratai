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
                    
                    

                    <?php include("components/sidebar.php")?>
                    <!-- REVIEW Deixar o template da tabela pronto para depois preenchê-la. -->
                    <div class="col-10 px-3 flex-column" id="settingsContent">
                        <div class="crud">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col">
                                        <h4>Gerenciamento de [tabela]</h4>
                                    </div>
                                    <div class="col">
                                        <div class="crud-buttons d-flex gap-3 justify-content-end">
                                            <a href="#add" class="btn btn-success">Adicionar [item]</a>
                                            <a href="#exclude" class="btn btn-danger">Excluir [item]</a>
                                        </div>
                                    </div>
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