<?php
    session_start();
    require("../php/utils.php");
    if (!isAuthenticated()) {
        echo json_encode([ "resposta" => "nao autenticado" ]);
        exit();
    }

    logout();

    $resposta = [
        "action" => true
    ];

    echo json_encode($resposta);
?>
