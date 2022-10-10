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

    // criação caso não exista
    if ($profId === "new") {
        $dscProf = $_POST["dscProf"];

        $profId = $profissao->insertProf($dscProf)["dados"];
    }
    if ($especId === "new") {
        $dscEspec = $_POST["dscEspec"];

        $especId = $profissao->insertEspec($profId, $dscEspec)["dados"];
    }

    require("../../database/Usuario.php");
    $usr = new Usuario();

    // inserção da especialização no usuário
    $result = $usr->insertEspec($_SESSION["idusr"], $especId);

    echo json_encode($result);
?>