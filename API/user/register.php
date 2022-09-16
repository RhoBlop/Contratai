<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");

    if (!isset($_POST["nome"], $_POST["email"], $_POST["senha"], $_POST["confirmSenha"]) ) {
        echo json_encode([
            "resposta" => "parametros errados da requisicao POST"
        ]);
        exit();
    }

    // classe PDO para realização de operações no BD
    require ("../../php/database/Usuario.php");
    $user = new Usuario();

    // destructuring das variáveis recebidas pelo POST request
    [$nome, $email, $senha, $confirmSenha] = [$_POST["nome"], $_POST["email"], $_POST["senha"], $_POST["confirmSenha"]];

    // checar se a $senha é igual à $confirmSenha

    $result = $user->insertBasicInfo($nome, $email, $senha);
    
    // resposta da API
    $response = $result;
    
    echo json_encode($response);
?>