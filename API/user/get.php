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
    require ("../../php/Database.php");
    $db = new Database();

    $idUsr = $_SESSION["idUsr"];
    // retorna array associativa com os dados do usuário caso exista
    $result = $db->selectUserById($idUsr);

    if ($result) {
        echo json_encode($result);
    }
?>