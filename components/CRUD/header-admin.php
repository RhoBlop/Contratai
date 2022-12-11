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
    $username = $_SESSION["username"];
?>

<header>
    <nav class="navbar navbar-expand-md fixed-top bg-light">
      <div class="container justify-content-center">
        <!-- HEADER LOGO -->
        <a class="navbar-brand" href="home.php">
          <img src="images/logo/blue-logo.svg" alt="Contratai Logo" height="32px">
        </a> <!-- /HEADER LOGO -->
      </div>
    </nav>
  </header>