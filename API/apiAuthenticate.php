<?php
    session_start();

    if (isset($_SESSION["idusr"])) {
        $response = [ "resposta" => true ];
    } else {
        $response = [ "resposta" => false ];
    }

    echo json_encode($response);
?>