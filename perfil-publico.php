<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?php include ("components/head.html") ?>
    </head>
    <body>
    <!-- HOME PAGE HEADER -->
        <?php include ("components/login-header.html"); ?>

        <main>
            <div class="container p-3 my-3">
                <div class="row gx-5">
                    <div class="col-7" id="profile">
                        <div class="card rounded-5">
                            <div class="header-card rounded-5  rounded-bottom">
                            </div>
                            <div class="card-body p-3 text-start">
                                <div class="top-body p-3 mb-3">
                                    <div class="profile-pic"><img src="images\temp\default-pic.png"class="rounded-circle" alt=""></div>
                                </div>

                                <div class="content px-3">
                                    <h3>Rafael Rodrigues Matos</h3>
                                    <p>Designer Gráfico</p>
                                    <p>Serra, ES</p>
                                </div>

                                

                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </main>


        <!-- FOOTER -->
        <?php include ("components/footer.html") ?>

        <!-- JS BOOTSTRAP BUNDLE -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
            crossorigin="anonymous"
        ></script>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>
</html>
