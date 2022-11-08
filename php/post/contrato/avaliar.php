<?php
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../verificacoes.php");
    require ("../../utils.php");
        
    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../../database/Contrato.php");
    $contrato = new Contrato();

    $idUser = $_SESSION["iduser"];
    [$contratoId, $nota, $comentario] = [$_POST["contratoId"], $_POST["nota"], $_POST["comentario"]];

    // inserção da especialização no usuário
    $result = $contrato->insertAvaliacao($contratoId, $idUser, $nota, $comentario);

    echo json_encode($result);
?>