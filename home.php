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
            <div class="container my-3">
                <div class="row py-3 d-flex justify-content-center align-items-center mb-3">
                    <div class="col-md-12 search-bar">
                        <!-- TODO Filtro de pesquisa -->
                        <form id="searchForm" onsubmit="return false" class="hidden">
                            <div class="input-group">
                                <input id="searchBox" name="searchParam" type="text" class="form-control form-control-lg" autocomplete="off" placeholder="O que você está procurando?">
                                <button id="searchButton" class="btn btn-green"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                            <div class="filters-group">
                                <input type="radio" id="profissao" class="search-filter" name="filterTable" value="profissao" checked>
                                <label for="profissao">Profissão</label>

                                <input type="radio" id="usuario" class="search-filter" name="filterTable" value="usuario">
                                <label for="usuario">Usuário</label>
                            </div>
                        </form>

                        <div id="searchResult">
                        </div>
                    </div>
                </div>

            </div>

            <script src="js/fetch/pesquisa.js"></script>


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

    <!-- Barra de pesquisa -->
    
    
    <!-- Sliding do carousel com animação -->
    <script src="js/multitemCarousel.js"></script>

    <!-- Scrolling -->
    <script src="js/scrolling.js"></script>
</html>