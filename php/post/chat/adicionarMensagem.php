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

    [$idDestinatario, $mensagem, $timestamp] = [$_POST["idDestinatario"], $_POST["mensagem"], $_POST["timestamp"]];

    $result = $chat->sendMessage($idDestinatario, $mensagem, $timestamp);

    echo json_encode($result);
?>