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
    require ("../../php/Database.php");
    $db = new Database();

    // destructuring das variáveis recebidas pelo POST request
    [$nome, $email, $senha, $confirmSenha] = [$_POST["nome"], $_POST["email"], $_POST["senha"], $_POST["confirmSenha"]];
    $result = $db->insertBasicUser($nome, $email, $senha);
    
    // resposta da API
    if ($result === true) {
        $response = [ "resposta" => "sucesso no cadastro" ];
    } else if ($result === "ja existe um usuario cadastrado com esse email") {
        $response = [ "resposta" => $result ];
    } else {
        $response = [ "resposta" => "falha no cadastro" ];
    }
    
    echo json_encode($response);
?>