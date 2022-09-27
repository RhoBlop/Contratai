<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require("components/head.php") ?>
    </head>
    <body>
        <?php include ("components/login-header.php") ?>
        <main>
            <div class="container my-3">
                <div class="row py-3 d-flex justify-content-center align-items-center mb-3">
                    <div class="col-md-12 search-bar">
                        <form id="searchForm" onsubmit="return false">
                            <div class="input-group">
                                <input id="searchBox" name="searchParam" type="text" class="form-control form-control-lg" autocomplete="off" placeholder="O que você está procurando?">
                                <button id="searchButton" class="btn btn-green"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                            <div class="filters-group">
                                <input type="radio" id="profissao" class="search-filter" name="filterTable" value="profissao">
                                <label for="profissao">Profissão</label>

                                <input type="radio" id="usuario" class="search-filter" name="filterTable" value="usuario" checked>
                                <label for="usuario">Usuário</label>
                            </div>
                        </form>

                        <div id="searchResult">
                            
                        </div>
                    </div>
                </div>
            </div>

            <script src="js/pesquisa.js"></script>


            <!-- CAROUSEL DAS PROFISSÕES COM MAIS CONTRATOS -->
            <?php include ("components/prof-top-contrato.php") ?>

            <!-- CAROUSEL DAS PROFISSÕES COM AVALIAÇÕES MAIS ALTAS -->
            <?php include ("components/prof-top-avaliacao.php") ?>

            <!-- CAROUSEL DAS PROFISSÕES COM MAIS CADASTROS -->
            <?php include ("components/prof-top-cadastro.php") ?>

            <div class="container my-3">
                    <div class="row row-cols-2 row-cols-lg-5 g-3 mb-3">

                        <!-- Card de Perfil (colocar na pagina de anuncio depois)
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
                        -->

                        <?php 
                        
                        for ($i=1; $i <= 10; $i++) {
                            include("components/card-anuncio.html");
                        }
                        
                        ?>
                                               
                    </div>
                    
            </div>

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

    <!-- Barra de pesquisa -->
    
    
    <!-- Sliding do carousel com animação -->
    <script src="js/multitemCarousel.js"></script>
</html>