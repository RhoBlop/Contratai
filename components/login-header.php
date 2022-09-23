<?php 
  session_start();
  require_once("php/database/Usuario.php");
  require_once("php/impressaoDados.php");

  $userClass = new Usuario();
  $user = carregaUsuario();
?>
<header>
    <nav class="navbar navbar-expand-md fixed-top bg-light">
      <div class="container">
        <!-- HEADER LOGO -->
        <a class="navbar-brand" href="home.php">
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
          <div class="offcanvas-body justify-content-end align-content-center">
            
            <div class="d-flex align-content-center">
              <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item">
                  <a class="btn btn-outline-green" href="#">Anuncie</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fa-regular fa-bell"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fa-regular fa-comments"></i></a>
                </li>
                <li class="nav-item dropdown p-2">
                  <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <!-- define uma imagem padrão caso o usuário não tenha nenhuma -->
                    <img id="headerImgPerfil" src="<?php echoImage($user["imgusr"]) ?>" alt="" width="32" height="32" class="rounded-circle">
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                    <li><a class="dropdown-item" href="perfil.php"><i class="fa-regular fa-user fa-lg pe-2"></i>Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-regular fa-comment fa-lg pe-2"></i>Mensagens</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-regular fa-bell fa-lg pe-2"></i>Notificações</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-regular fa-heart fa-lg pe-2"></i>Favoritos</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gears fa-lg pe-2"></i>Configurações</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" onclick="logout()"><i class="fa-solid fa-arrow-right-from-bracket fa-lg pe-2"></i>Sair</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div> 
      </div>
    </nav>
  </header>