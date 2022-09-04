<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");

    if (!isset($_POST["nome"], $_POST["email"], $_POST["senha"]) ) {
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
    require ("../Database.php");
    $db = new Database();
?>