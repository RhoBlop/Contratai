<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <?php require("components/head.php") ?>
  </head>
  <body>
    <!-- HOME PAGE HEADER -->
    <?php include ("components/no-auth-header.php"); ?>

    <main>
      <div class="container p-3 my-5">
        <div class="row d-flex justify-content-center align-items-center my-3 py-3">
            <div class="col-sm-5 p-5">
              <h2 class="mb-3">Quem somos?</h2>
              <p>Criado por um grupo de 3 alunos do curso técnico de informática do IFES Serra, 
              o Contrata Aí é um site que conecta clientes e profissionais capacitados, com o objetivo 
              de facilitar a comunicação entre eles.</p>
              <p>Acreditamos que, o que era pra ser um Projeto de conclusão de curso, possa ajudar milhares 
                de pessoas ao redor do país, quem dirá do mundo! 
              </p>
            </div>
            <div class="col-sm-5 col-xxl-7 p-3">
              <img src="images\storyset\design-team-animate.svg" width="100%" alt="">
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
 