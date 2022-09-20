<?php
    session_start();
    require("../php/verificacoes.php");
    require("../php/utils.php");

    verifyIsAuthenticated();

    logout();

    $resposta = [
        "action" => true
    ];

    echo json_encode($resposta);
?>
