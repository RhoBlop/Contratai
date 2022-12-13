<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../verificacoes.php");
    require ("../../utils.php");
        
    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../../database/Profissao.php");
    $profissao = new Profissao();

    $profId = $_POST["profId"];

    $result = $profissao->selectProfById($profId);

    echo json_encode($result);
?>