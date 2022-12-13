<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <?php require("components/head.php") ?>
  </head>
  <body>
    <!-- HOME PAGE HEADER -->
    <?php include ("components/header-no-auth.php"); ?>

    <main>
      <div class="container p-3">
        <div class="row d-flex justify-content-center align-items-center py-3 hidden">
            <div class="col-sm-5 p-5">
              <h2 class="mb-3">O que é?</h2>
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
          
          <div class="row hidden">
            <div class="col-12 p-3" id="teamSection">
              <div class="text-center my-3">
                <h2 class="m-0">Nosso time</h2>
                <p>Veja quem são os nossos desenvolvedores!</p>
              </div>
            </div>
            <div class="teamIntegrant col d-flex flex-column align-items-center text-center">
              <div class="integrant-img my-2">
                <img src="images\sobre\rafael.jpeg" alt="Rafael Rodrigues">
              </div>
              <h3 class="m-0">Rafael Rodrigues</h3>
              <p>Designer e programador Front-end<p>
            </div>
            <div class="teamIntegrant col d-flex flex-column align-items-center text-center">
              <div class="integrant-img my-2">
                <img src="images\sobre\thiago.jpeg" alt="Thiago Neves">
              </div>
              <h3 class="m-0">Thiago Neves</h3>
              <p>Programador Front e Back-end<p>
            </div>
            <div class="teamIntegrant col d-flex flex-column align-items-center text-center">
              <div class="integrant-img my-2">
                <img src="images\sobre\matheus.jpeg" alt="Matheus Magnago" id="matheus">
              </div>
              <h3 class="m-0">Matheus Magnago</h3>
              <p>Idealizador do projeto<p>
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
    <script src="js/scrolling.js"></script>
  </body>
</html>
 