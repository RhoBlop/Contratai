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
                    
                    <?php include("components/modal-exclude.html")?>

                    <?php include("components/sidebar.html")?>

                    <div class="col-8 px-3 flex-column text-center" id="settingsContent">
                        <h3>Esta pagina está em desenvolvimento...</h3>
                        <img src="images\storyset\Work time-pana.svg" alt="">
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