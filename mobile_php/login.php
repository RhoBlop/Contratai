<?php 

    require_once('conexao_db.php');
    require_once('autenticacao.php');

    $resp = array();

    if (autenticar($db_con)) {
        $resp["sucesso"] = 1;
    }
    else {
        $resp["sucesso"] = 0;
        $resp["erro"] = "usuario ou senha não confere";
    }

    $db_con = null;

    echo json_encode($resp);
?>