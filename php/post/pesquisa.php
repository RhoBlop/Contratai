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
    } else if ($filterTable == "profissao") {
        $response = $search->searchProf($searchParam, $limit = $searchLimit, $offset = $searchOffset);
    } else {
        $response = [
            "erro" => "filtro inválido"
        ];
    }

    echo json_encode($response);
?>