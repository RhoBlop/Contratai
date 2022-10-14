<?php
    require("php/database/Usuario.php");
    require("php/database/Profissao.php");
    require("php/impressaoDados.php");
    require("php/utils.php");

    if (isset($_SESSION["iduser"])) {
        $auth = true;
    } else {
        $auth = false;
    }
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1">
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

<!-- DAY.JS -->
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/locale/pt-br.js"></script>

<!-- CUSTOM CSS -->
<link rel="stylesheet" href="css/style.css">

<!-- COISOS QUE PISCAM NA TELA (MODAL, TOAST...) -->
<script src="js/popups.js"></script>

<!-- FUNÇÕES GERAIS, SEM LIGAÇÃO COM ALGO ESPECÍFICO -->
<script src="js/utils.js"></script>

<!-- JAVASCRIPT PARA MUDAR A CLASSE DOS LINKS ATIVOS NO HEADER E SIDEBAR -->
<script src="js/activeLinks.js"></script>

<!-- REQUISIÇÕES PARA O BACKEND -->
<script src="js/fetch/formularios.js"></script>
