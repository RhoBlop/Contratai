<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <?php require("components/head.php") ?>
  </head>
  <body>
    <!-- HOME PAGE HEADER -->
    <?php include ("components/header-no-auth.php"); ?>

    <main>
      <div class="container my-lg-3">
        <div class="row d-flex align-items-center flex-wrap justify-content-center" id="fContent">
          <div class="top-content col-12 col-lg-7 mb-4 mb-md-0">
          <div class="title my-3">
            <h1>Ajudando você</h1> 
            <h1 class="text-gradient">sempre!</h1>
          </div>
            <p class="text-muted">Você encontrará os melhores profissionais aqui<br>no Contrataí!</p>
            <form action="cadastro.php" method="GET">
              <!-- BOTÕES PARA FILTRAGEM DA PESQUISA POR SERVIÇO -->
              <div class="filtros-servico d-flex flex-wrap my-lg-3 my-4">
                <div class="item-pesquisa">
                    <button id="eletricista" class="btn btn-outline-dark btn-lg" name="filtro-servico">Eletricista</button>
                </div>
                <div class="item-pesquisa">
                    <button id="encanador" class="btn btn-outline-dark btn-lg" name="filtro-servico">Encanador</button>
                </div>
                <div class="item-pesquisa">
                    <button id="diarista" class="btn btn-outline-dark btn-lg" name="filtro-servico">Diarista</button>
                </div>
                <div class="item-pesquisa">
                    <button id="carpinteiro" class="btn btn-outline-dark btn-lg" name="filtro-servico">Carpinteiro</button>
                </div>
                <div class="item-pesquisa">
                    <button id="pedreiro" class="btn btn-outline-dark btn-lg" name="filtro-servico">Pedreiro</button>
                </div>
                <div class="item-pesquisa">
                    <button id="jardineiro" class="btn btn-outline-dark btn-lg" name="filtro-servico">Jardineiro</button>
                </div>
                <div class="item-pesquisa">
                    <button id="pintor" class="btn btn-outline-dark btn-lg" name="filtro-servico">Pintor</button>
                </div>
                <div class="item-pesquisa">
                    <button id="designer" class="btn btn-outline-dark btn-lg" name="filtro-servico">Designer</button>
                </div>
                </div>
            </form>
          </div>
  
          <div class="col-12 col-lg-5 mb-3 mb-sm-0">
            <img src="images\storyset\business-merger-animate.svg" alt="Stock Image Trabalhador" width="100%" min-width=300px>
          </div>
        </div>
      </div>

      <!-- CAROUSEL DAS PROFISSÕES COM MAIS CONTRATOS -->
      <?php include ("components/prof-top-contrato.php") ?>

      <!-- CAROUSEL DAS PROFISSÕES COM AVALIAÇÕES MAIS ALTAS -->
      <?php include ("components/prof-top-avaliacao.php") ?>

      <!-- GRID DE AVALIAÇÕES ESTÁTICAS -->
      <?php include ("components/avaliacoes-index.html") ?>

      <!-- BANNER DE LOGIN -->
      <div class="login-banner d-flex flex-column align-items-center justify-content-center text-center mb-4 p-3">
        <h2 class="text-white mb-3">Gostou? Então não perca mais tempo!</h2>
        <a href="cadastro.php" class="btn btn-dark btn-lg mt-3">Comece já</a>
      </div> <!-- /BANNER DE LOGIN -->
    </main>
    

    <!-- FOOTER -->
    <?php include ("components/footer.html") ?>
    
    
    <!-- JS BOOTSTRAP BUNDLE -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    <!-- Sliding do carousel com animação -->
    <script src="js/multitemCarousel.js"></script>
    <script>
        // define se o modal de login deve ser aberto quando a página é carregada
      // isso é usado, por exemplo, quando uma pessoa realiza o cadastro e é redirecionada ao index
      checkForOpenModal();
    </script>
  </body>
</html>
 