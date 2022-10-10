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

    [$profId, $especId] = [$_POST["profId"], $_POST["especId"]];

    if ($profId === "new") {
        $dscProf = $_POST["dscProf"];

        echo $dscProf;
    }

    if ($especId === "new") {
        $dscEspec = $_POST["dscEspec"];

        echo $dscEspec;
    }
    echo $profId;
    echo $especId;
    exit();

    $result = $profissao->selectEspecs($profId);

    echo json_encode($result);
?>