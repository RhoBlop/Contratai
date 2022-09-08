<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");

    // falta localizacao
    if (!isset($_POST["nome"], $_POST["email"], $_POST["localizacao"], $_POST["nascimento"], $_POST["bio"]) ) {
        echo json_encode([
            "resposta" => "parametros errados da requisicao POST"
        ]);
        exit();
    }

    session_start();
    require("../../php/utils.php");
    if (!isAuthenticated()) {
        echo json_encode([ "resposta" => "nao autenticado" ]);
        exit();
    }
    // classe PDO para realização de operações no BD
    require ("../../php/Database.php");
    $db = new Database();
?>