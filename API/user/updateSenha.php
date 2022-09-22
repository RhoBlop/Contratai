<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../../php/verificacoes.php");

    verifyIsSetPost("senhaAtual", "senhaNova", "confirmSenhaNova");

    verifyIsEmptyPost("senhaAtual", "senhaNova", "confirmSenhaNova");

    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../../php/database/Usuario.php");
    $user = new Usuario();

    [$senhaAtual, $senhaNova, $confirmSenhaNova] = [$_POST["senhaAtual"], $_POST["senhaNova"], $_POST["confirmSenhaNova"]];

    if ($senhaNova == $confirmSenhaNova) {
        $response = $user->updateSenha($_SESSION["idusr"], $senhaAtual, $senhaNova);
        
        echo json_encode($response);
    }

    ?>