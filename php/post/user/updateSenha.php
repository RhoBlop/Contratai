<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../verificacoes.php");

    verifyIsSetPost("senhaAtual", "senhaNova", "confirmaSenhaNova");

    verifyIsEmptyPost("senhaAtual", "senhaNova", "confirmaSenhaNova");

    session_start();
    verifyIsAuthenticated();

    // classe PDO para realização de operações no BD
    require ("../../database/Usuario.php");
    $user = new Usuario();

    [$senhaAtual, $senhaNova, $confirmaSenhaNova] = [$_POST["senhaAtual"], $_POST["senhaNova"], $_POST["confirmaSenhaNova"]];

    if ($senhaNova == $confirmaSenhaNova) {
        $response = $user->updateSenha($_SESSION["idusr"], $senhaAtual, $senhaNova);
        
        echo json_encode($response);
    }

    ?>