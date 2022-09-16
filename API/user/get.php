<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
        
    session_start();
    require ("../../php/utils.php");
    if (!isAuthenticated()) {
        echo json_encode([ "resposta" => "nao autenticado" ]);
        exit();
    }

    // classe PDO para realização de operações no BD
    require ("../../php/database/Usuario.php.php");
    $user = new Usuario();

    // retorna array associativa com os dados do usuário caso exista
    $result = $user->getById($_SESSION["idUsr"]);

    $response = $result;

    echo json_encode($response);
?>