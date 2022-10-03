<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <?php require("components/head.php") ?>
  </head>
  <body>
    <!-- HOME PAGE HEADER -->
    <?php include ("components/no-auth-header.php"); ?>

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

      <!-- CAROUSEL DAS PROFISSÕES COM MAIS CONTRATOS -->
      <?php include ("components/prof-top-contrato.php") ?>

      <!-- CAROUSEL DAS PROFISSÕES COM AVALIAÇÕES MAIS ALTAS -->
      <?php include ("components/prof-top-avaliacao.php") ?>

      <!-- GRID DE AVALIAÇÕES ESTÁTICAS -->
      <?php include ("components/avaliacoes-index.html") ?>

      <!-- BANNER DE LOGIN -->
      <div class="login-banner d-flex flex-column align-items-center justify-content-center mb-5">
        <h2 class="text-white mb-3">Gostou? Então não perca mais tempo!</h2>
        <a type="button" class="btn btn-dark btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#modal-login">Comece já</a>
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
 