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

    $contratanteId = $_SESSION["iduser"];
    [$contratadoId , $especId, $descricao, $diasContrato] = [$_POST["contratadoId"], $_POST["idEspec"], $_POST["descricao"], explode(" || ", $_POST["multidate"])];

    // inserção da especialização no usuário
    $result = $contrato->insertContrato($contratanteId, $contratadoId, $especId, $descricao, $diasContrato);

    echo json_encode($result);
?>