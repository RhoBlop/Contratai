<?php
    session_start();
    require("verificacoes.php");
    require("../utils.php");

    verifyIsAuthenticated();

    logout();

    $resposta = [
        "dados" => true
    ];

    echo json_encode($resposta);
?>
