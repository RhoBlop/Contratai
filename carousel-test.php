<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <?php require("components/head.php") ?>
  </head>
  <body>
    <!-- HOME PAGE HEADER -->
    <?php include ("components/home-header.html"); ?>

    <!-- MODAL -->
    <?php include ("components/login-modal.html"); ?>

    <main>
      <div class="container p-3 my-3">
        <div class="row d-flex align-items-center flex-wrap justify-content-center">
          <!-- CAIXA DE PESQUISA -->
          <div class="col-sm-7 col-11 mb-4 mb-md-0">
          <h1>Ajudando você</h1> <h1 class="text-gradient">sempre!</h1>
            <!-- tive que botar um <br> mesmo fodase.. -->
            <h6 class="text-muted">Você encontrará os melhores profissionais aqui, <br>no Contrataí!</h6>
            <form action="cadastro.php" method="GET">
              <!-- BOTÕES PARA FILTRAGEM DA PESQUISA POR SERVIÇO -->
                <?php include ("components/filtros-servico.html") ?>
            </form>
          </div> <!-- /CAIXA DE PESQUISA -->
  
          <div class="col-sm-5 col-8">
            <img src="images\storyset\business-merger-animate.svg" alt="Stock Image Trabalhador" width="100%" min-width=300px>
          </div>
        </div>
      </div>

      <!-- CAROUSEL -->
      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="..." class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
          </div>
		  <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
          </div>
		  <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
          </div>
		  <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

      
    </main>
    

    <!-- FOOTER -->
    <?php include ("components/footer.html") ?>


    <!-- JS BOOTSTRAP BUNDLE -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    <script>
      // define se o modal de login deve ser aberto quando a página é carregada
      // isso é usado, por exemplo, quando uma pessoa realiza o cadastro e é redirecionada ao index
      checkForOpenModal();
    </script>
  </body>
</html>
 