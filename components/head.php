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
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
/>

<script src="https://kit.fontawesome.com/d21e3e40d7.js" crossorigin="anonymous"></script>

<!-- CUSTOM CSS -->
<link rel="stylesheet" href="css/style.css">

<!-- COISOS QUE PISCAM NA TELA (MODAL, TOAST...) -->
<script src="../js/popups.js"></script>

<!-- JAVASCRIPT PARA MUDAR A CLASSE DOS LINKS ATIVOS NO HEADER E SIDEBAR -->
<script src="../js/activeLinks.js"></script>

<!-- REQUISIÇÕES PARA O BACKEND -->
<script src="../js/requisicoesAPI.js"></script>

<?php
    session_start();
    require("php/database/Usuario.php");
    require("php/database/Profissao.php");
    require("php/impressaoDados.php");
    require("php/utils.php");

    $auth = isAuthenticated();
    $usuarioClass = new Usuario();
    $profissaoClass = new Profissao();
?>
