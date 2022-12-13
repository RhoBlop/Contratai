<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <?php require("components/head.php") ?>
  </head>
  <body>

    <main class="d-flex align-items-center">
      <div class="container p-3 mt-5 ">
        <div class="row d-flex justify-content-center align-content-center p-3">
            
            <div class="col-sm-5 col-xxl-6 py-3">
              <img src="images\storyset\bad-idea-animate.svg" width="100%" alt="">
            </div>

            <div class="col-sm-5 col-xxl-6 flex-column py-5 text-center align-self-center ">
              <h1 class="mb-3">Poxa!</h1>
              <p class="fs-4">Uma pena você ter abandonado nosso serviço! <br>Quem sabe você possa tentar começar novamente?</p>
              <a type="button" class="btn btn-outline-green btn-lg mt-3" href="cadastro.php">Cadastre-se</a>
            </div>
        </div>
      </div>
    </main>
    
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
 