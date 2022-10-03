<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <?php require("components/head.php") ?>
  </head>
  <body>

    <?php 
        if (!isset($_GET["id"])):
    ?>

        <main class="d-flex align-items-center">
            <div class="container p-3 mt-5 ">
            <div class="row d-flex justify-content-center align-content-center p-3">
                
                <div class="col-sm-5 col-xxl-6 py-3">
                    <img src="images\storyset\bad-idea-animate.svg" width="100%" alt="">
                </div>
    
                <div class="col-sm-5 col-xxl-6 flex-column py-5 text-center align-self-center ">
                    <h1 class="mb-3">Redefinição de senha</h1>
                    <p class="fs-4">Um email será enviado para você no endereço provido para seja possível redefinir sua senha.</p>
                    <form action="#" method="POST">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email">
                    </form>
                </div>
            </div>
            </div>
        </main>
    
    <?php 
        else:
            // CHECK IF ID MATCHES ON DATABASE
            mail();
        endif;
    ?>

            

    <?php
        endif;
    ?>

    
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
 