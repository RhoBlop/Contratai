<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../php/verificacoes.php");
    require ("../php/utils.php");

    // termina o serviço caso alguma das variáveis não tenha sido enviada no POST
    verifyIsSetPost("searchParam");
        
    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../php/database/Pesquisa.php");
    $search = new Pesquisa();

    [$searchParam, $filterTable] = [$_POST["searchParam"], $_POST["filterTable"]];
    
    if (count($filterTable) == 1) {
        $response = $search->searchTable($searchParam, $filterTable[0]);
    
        echo json_encode($response);
    }
?>