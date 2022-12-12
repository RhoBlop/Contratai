<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require("../verificacoes.php");
    require("../../utils.php");
    
    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../../database/Profissao.php");
    $profissaoClass = new Profissao();
    
    [$idProf, $descrProf] = [$_POST['idProf'], $_POST['descrProf']];

    if ($_FILES["imgProf"]["name"] !== "") {
        $dir = "profissao/";
        $imgs = uploadImgsToServer($idProf, $dir, $_FILES);

        $imgPath = $imgs[0];
    } else {
        $imgPath = null;
    }

    $result = $profissaoClass->updateProf($idProf, $descrProf, $imgPath);

    echo json_encode($result);
?>