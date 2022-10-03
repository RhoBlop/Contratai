<header id="mainHeader">
  <nav class="navbar navbar-expand-md fixed-top bg-light">
    <div class="container">
      <!-- HEADER LOGO -->
      <a class="navbar-brand" href="index.php">
        <img src="images/logo/blue-logo.svg" alt="Contratai Logo" height="32px">
      </a> <!-- /HEADER LOGO -->
      <!-- SIDEBAR TOGGLER -->
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
      </button> <!-- /SIDEBAR TOGGLER -->
      <!-- SIDEBAR -->
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <!-- SIDEBAR HEADER -->
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Contratai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div> <!-- /SIDEBAR HEADER -->
        <!-- SIDEBAR BODY -->
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-center flex-grow-1">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.php">Início</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="sobre.php">Sobre</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="ajuda.php">Ajuda</a>
            </li>
          </ul>
          <div class="d-flex justify-content-end align-items-center flex-grow 1">
            <a type="button" class="btn btn-login me-3 px-2" data-bs-toggle="modal" data-bs-target="#modal-login">Login</a>
            <a type="button" class="btn btn-outline-green" href="cadastro.php">Cadastre-se</a>
          </div>
        </div><!-- /SIDEBAR BODY -->
      </div> <!-- /SIDEBAR -->
    </div>
  </nav>
</header>

<?php include("components/login-modal.html"); ?>