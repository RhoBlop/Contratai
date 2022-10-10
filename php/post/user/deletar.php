<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require("../verificacoes.php");
    require("../../utils.php");
    
    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../../database/Usuario.php");
    $user = new Usuario();

    $result = $user->deleteById($_SESSION["idusr"]);

    // resposta da API
    if (isset($result["dados"]) && $result["dados"] === TRUE) {
        logout();
    }

    $response = $result;

    echo json_encode($response);
?>