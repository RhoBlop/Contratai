<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("verificacoes.php");
    require ("../utils.php");
        
    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../database/Pesquisa.php");
    $search = new Pesquisa();

    [$searchParam, $filterTable, $searchLimit, $searchOffset] = [$_POST["searchParam"], $_POST["filterTable"], $_GET["limit"], $_GET["offset"]];

    if ($filterTable == "usuario") {
        $response = $search->searchUser($searchParam, $limit = $searchLimit, $offset = $searchOffset);

        echo json_encode($response);
    } else {
        echo json_encode([
            "erro" => "Ainda em desenvolvimento"
        ]);
    }

?>