<?php 
    if (!$auth) {
        header("Location: cadastro.php");
        exit();
    }

    if ((isset($_SESSION["admin"])) && ($_SESSION["admin"] === true)) {
        $admin = true;
    } else {
        $admin = false;
    }

    $usuarioClass = new Usuario();
    $user = $usuarioClass->selectBasicInfoById($_SESSION["iduser"]);
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
                  <a class="btn btn-outline-green" href="profissoes.php">Anuncie</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contratos.php"><i class="fa-solid fa-address-book"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="notificacoes.php"><i class="fa-regular fa-bell"></i></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#"><i class="fa-regular fa-comments"></i></a>
                </li>

                <?php 
                    if ($admin === true):
                ?>
                    <li class="nav-item">
                    <a class="nav-link" href="admin.php"><i class="fa-solid fa-screwdriver-wrench"></i></a>
                    </li>
                <?php
                    endif;
                ?>

                <li class="nav-item dropdown p-2">
                  <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <!-- define uma imagem padrão caso o usuário não tenha nenhuma -->
                    <img id="headerImgPerfil" src="<?php echoProfileImage($user["imguser"]) ?>" alt="Imagem de perfil">
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                    <div class="text-center px-2">Olá, <?php echo $user["nomeuser"] ?></div>
                    
                    <li><hr class="dropdown-divider"></li>

                    <li><a class="dropdown-item" href="perfil.php"><i class="fa-regular fa-user fa-lg pe-2"></i>Perfil</a></li>

                    <?php 
                        if ($admin === true):
                    ?>
                        <li><a class="dropdown-item" href="admin.php"><i class="fa-solid fa-screwdriver-wrench fa-lg pe-2"></i>Admin</a></li>
                    <?php
                        endif;
                    ?>

                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-regular fa-bell fa-lg pe-2"></i>Notificações</a></li>
                    <li><a class="dropdown-item" href="contratos.php"><i class="fa-solid fa-address-book fa-lg pe-2"></i>Contratos</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-regular fa-comment fa-lg pe-2"></i>Mensagens</a></li>
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
