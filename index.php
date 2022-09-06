<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <?php include ("components/head.html") ?>
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
            <form action="" method="POST">
              <!-- BOTÕES PARA FILTRAGEM DA PESQUISA POR SERVIÇO -->
                <?php include ("components/filtros-servico.html") ?>
            </form>
          </div> <!-- /CAIXA DE PESQUISA -->
  
          <div class="col-sm-5 col-8">
            <img src="images\Code typing (1).gif" alt="Stock Image Trabalhador" width="100%" min-width=200px>
          </div>
        </div>
      </div>

      <!-- SLIDER DAS PRINCIPAIS CATEGORIAS -->
      <?php include ("components/principais-categorias.html") ?>

      <!-- SLIDER DE AVALIAÇÕES -->
      <?php include ("components/avaliacoes-home.html") ?>

      <!-- BANNER DE LOGIN -->
      <div class="login-banner d-flex flex-column align-items-center justify-content-center mb-5">
        <h2 class="text-white mb-3">Gostou? Então não perca mais tempo!</h2>
        <button class="btn btn-dark btn-lg mt-3">Comece já</button>
      </div> <!-- /BANNER DE LOGIN -->
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
 