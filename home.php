<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/login-header.php") ?>
        <main>
            
            <div class="container p-3 my-3">
                <div class="row d-flex justify-content-center align-items-center mb-3">
                    <div class="col-md-12">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" placeholder="O que você está procurando?">
                                <button class="btn btn-green"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>

            <!-- CAROUSEL DAS PROFISSÕES COM MAIS CONTRATOS -->
            <?php include ("components/prof-top-contrato.php") ?>

            <!-- CAROUSEL DAS PROFISSÕES COM AVALIAÇÕES MAIS ALTAS -->
            <?php include ("components/prof-top-avaliacao.php") ?>

            <!-- CAROUSEL DAS PROFISSÕES COM MAIS CADASTROS -->
            <?php include ("components/prof-top-cadastro.php") ?>

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
    
    <!-- Sliding do carousel com animação -->
    <script src="js/multitemCarousel.js"></script>
</html>