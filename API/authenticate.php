<?php
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");

    session_start();
    require("../php/utils.php");

    if (isAuthenticated()) {
        $response = [ 
            "resposta" => "autenticado",
            "auth" => true
        ];
    } else {
        $response = [ 
            "resposta" => "nao autenticado",
            "auth" => false
        ];
    }

    echo json_encode($response);
?>