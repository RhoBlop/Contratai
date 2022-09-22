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
    require ("../../php/database/Usuario.php");
    $user = new Usuario();

    // retorna array associativa com os dados do usuário caso exista
    $result = $user->selectById($_SESSION["idusr"]);

    echo json_encode($result);
?>