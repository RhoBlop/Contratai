<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include ("components/head.html") ?>
    </head>
    <body>
        <?php include ("components/login-header.html") ?>
        <main>
            <div class="container my-3">

                <div class="row py-3 d-flex justify-content-center align-items-center mb-3">
                    <div class="col-md-12 search-bar">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" placeholder="O que você está procurando?">
                                <button class="btn btn-green"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>

            <div class="container my-3">
                    <div class="row row-cols-2 row-cols-lg-5 mb-3">
                        <div class="col">
                            <div class="card text-center shadow-sm rounded-4" id="profile-card">
                                <div class="card-header">
                                    <div class="profile-pic"><img src="images\temp\default-pic.png" class="rounded-circle" alt=""></div>
                                </div>
                                <div class="card-body">
                                    <div class="text mb-3">
                                        <h3>Fulano</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint, tempore.</p>
                                    </div>
                                    <a class="btn btn-outline-green" href="perfil-publico.php">Veja mais</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
            </div>


            <!-- SLIDER DAS PRINCIPAIS CATEGORIAS -->
            <?php include ("components/principais-categorias.html") ?>

        </main>
        <?php include ("components/footer.html")?>
    </body>

    <script>
        // seta os campos da table com os dados do usuário
        let user = getLocalStorageUser();
        let { imgusr } = user;

        if (imgusr) {
            document.querySelector("#headerImgPerfil").src = imgusr;
        }
    </script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</html>