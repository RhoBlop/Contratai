<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrataí</title>

    <!-- SVG FAVICON -->
    <link rel="icon" href="images/logo/favicon.svg" sizes="any" type="image/svg+xml">

    <!-- BOOTSTRAP CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />

    <!-- FONT AWESOME -->


    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <!-- HOME PAGE HEADER -->
    <?php include ("components/home-header.html"); ?>

    <main>
      <div class="container p-3 my-3">
        <div class="row d-flex align-items-center flex-wrap justify-content-center">
          <!-- CAIXA DE PESQUISA -->
          <div class="col-sm-7 col-11 mb-4 mb-md-0">
            <h1>Ajudando você sempre!</h1>
            <h6 class="text-muted">Você encontrará os melhores profissionais aqui, no Contrataí!</h6>
            <form action="" method="POST">
              <div class="barra-pesquisa">
                <input id="pesquisa" type="text" placeholder="O que você está procurando?" style="width: 75%">
                <!-- ÍCONE DE PESQUISA -->
              </div>
              <!-- BOTÕES PARA FILTRAGEM DA PESQUISA POR SERVIÇO -->
                <?php include ("components/filtros-servico.html") ?>
            </form>
          </div> <!-- /CAIXA DE PESQUISA -->
  
          <div class="col-sm-5 col-8">
            <img src="images/worker-home-gradient.svg" alt="Stock Image Trabalhador" width="100%" min-width=200px>
          </div>
        </div>
      </div>

      <!-- SLIDER DAS PRINCIPAIS CATEGORIAS -->
      <?php include ("components/principais-categorias.html") ?>

      <!-- SLIDER DE AVALIAÇÕES -->
      <?php include ("components/avaliacoes-home.html") ?>

      <!-- BANNER DE LOGIN -->
      <div class="login-banner d-flex flex-column align-items-center justify-content-center">
        <h1 class="text-white">Gostou? Então não perca mais tempo!</h1>
        <button class="btn btn-dark">Comece já</button>
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
  </body>
</html>
