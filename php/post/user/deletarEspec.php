<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../verificacoes.php");
    require ("../../utils.php");
        
    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../../database/Usuario.php");
    $usr = new Usuario();

    $especId = $_POST["especId"];

    // inserção da especialização no usuário
    $result = $usr->deleteEspecById($_SESSION["idusr"], $especId);

    echo json_encode($result);
?>