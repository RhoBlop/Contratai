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
    require ("../Database.php");
    $db = new Database();

    $idUsr = $_SESSION["idUsr"];
    $result = $db->deleteUser($idUsr);

    // resposta da API
    if ($result === true) {
        $response = [ "resposta" => "sucesso na delecao" ];
    } else {
        $response = [ "resposta" => "falha na delecao" ];
    }

    echo json_encode($response);
?>