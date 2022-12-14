<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../verificacoes.php");
    require ("../../utils.php");
        
    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../../database/Usuario.php");
    $user = new Usuario();

    $especId = $_POST["especId"];

    // inserção da especialização no usuário
    $result = $user->deleteEspecById($_SESSION["iduser"], $especId);

    echo json_encode($result);
?>