<?php
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../verificacoes.php");
    require ("../../utils.php");
        
    session_start();
    verifyIsAuthenticated();

    $idSender = $_SESSION["iduser"];

    require ("../../database/Chat.php");
    $chat = new Chat($idSender);

    $idDestinatario = $_POST["idDestinatario"];

    $result = $chat->getContactMessages($idDestinatario);

    echo json_encode($result);
?>