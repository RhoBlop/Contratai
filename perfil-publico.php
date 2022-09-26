<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <?php include ("components/head.php") ?>
    </head>
    <body>
    <!-- HOME PAGE HEADER -->
        <?php include ("components/login-header.php") ?>

        <main>
            <div class="container my-3">
                <div class="row gx-5">
                    <div class="col-8" id="profile">
                        <div class="card shadow-sm rounded-4 mb-3" id="infos">
                            <div class="header-card rounded-4  rounded-bottom">
                            </div>
                            <div class="card-body p-3 text-start">
                                <div class="top-body p-3 mb-1">
                                    <div class="profile-pic"><img src="images\temp\default-pic.png"class="rounded-circle" alt=""></div>
                                </div>

                                <div class="text px-3">
                                    <h3>Rafael Rodrigues Matos</h3>
                                    <p><i class="fa-solid fa-briefcase fa-fw"></i>Designer Gráfico</p>
                                    <p><i class="fa-solid fa-location-dot fa-fw"></i>Serra, ES</p>
                                    <p><i class="fa-solid fa-star fa-fw"></i>5.0</p>
                                    <p>100 Trabalhos realizados</p>
                                    <a href="#">50 Avaliações recebidas</a><br>
                                    <a href="#" class="btn btn-outline-green mt-3">Contactar</a>
                                </div>

                            </div>
                        </div>

                        
                        <div class="card shadow-sm rounded-4 mb-3" id="sobre">
                            <div class="card-body">
                                <h3 class="card-title">Sobre</h3>
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eligendi eum porro, doloremque a fuga nobis excepturi provident soluta deserunt iusto laborum ducimus pariatur magnam doloribus consectetur quo alias sed sunt! Totam atque iusto tenetur id! Id non alias, necessitatibus molestiae voluptas natus sapiente corrupti cumque ipsam. Id dolorem repellat eligendi.</p>
                            </div>
                        </div>

                        <div class="card shadow-sm rounded-4 mb-3" id="avaliacao">
                            <div class="card-body">
                                <h3 class="card-title mb-3">Avaliações</h3>
                                
                                <div class="subtitle d-flex gap-1 mb-3">
                                <i class="fa-solid fa-star fa-fw"></i>
                                    <h4 class="mb-3">4.5 de 50 Avaliações</h4>
                                </div>

                                <div class="row g-3">
                                    <div class="avaliacao col">
                                        <div class="avaliacao-header d-flex align-items-start gap-3 mb-3">
                                            <img src="images/temp/person-rating.png" width="48px">
                                            <div class="d-flex flex-column">
                                                <h5 class="mb-0">Fulano</h5>
                                                <p class="text-muted">Abril de 2022</p>
                                            </div>
                                        </div>

                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facilis corporis ratione cum aut. Saepe dolores nostrum numquam accusantium, culpa libero, iusto dicta itaque aut voluptatum animi nam inventore hic placeat.</p>
                                    </div>
                                    <div class="avaliacao col">
                                        <div class="avaliacao-header d-flex align-items-start gap-3 mb-3">
                                            <img src="images/temp/person-rating.png" width="48px">
                                            <div class="d-flex flex-column">
                                                <h5 class="mb-0">Fulano</h5>
                                                <p class="text-muted">Abril de 2022</p>
                                            </div>
                                        </div>

                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facilis corporis ratione cum aut. Saepe dolores nostrum numquam accusantium, culpa libero, iusto dicta itaque aut voluptatum animi nam inventore hic placeat.</p>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>



                    <div class="col-4">

                        <div class="row mb-5" id="fotos">
                            <h3>Galeria</h3>

                            <div class="col-10 p-0">
                                <div class="big-photo">
                                    <img src="images\temp\eletricista.png" alt="">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="row g-2">
                                    <div class="sm-photo">
                                        <img src="images\temp\eletricista.png" alt="">
                                    </div>
                                    <div class="sm-photo">
                                        <img src="images\temp\eletricista.png" alt="">
                                    </div>
                                    <div class="sm-photo">
                                        <img src="images\temp\eletricista.png" alt="">
                                    </div>
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
