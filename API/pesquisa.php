<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../php/verificacoes.php");
    require ("../php/utils.php");

    // termina o serviço caso alguma das variáveis não tenha sido enviada no POST
    verifyIsSetPost("searchParam", "filterTable");
        
    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../php/database/Pesquisa.php");
    $search = new Pesquisa();

    [$searchParam, $filterTable] = [$_POST["searchParam"], $_POST["filterTable"]];

    $response = $search->searchTable($filterTable);

    echo json_encode($response);
?>