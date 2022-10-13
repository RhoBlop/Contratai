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
        $descrProf = $_POST["descrProf"];

        $profId = $profissao->insertProf($descrProf)["dados"];
    }
    if ($especId === "new") {
        $descrEspec = $_POST["descrEspec"];

        $especId = $profissao->insertEspec($profId, $descrEspec)["dados"];
    }

    require("../../database/Usuario.php");
    $user = new Usuario();

    // inserção da especialização no usuário
    $result = $user->insertEspec($_SESSION["iduser"], $especId);

    echo json_encode($result);
?>