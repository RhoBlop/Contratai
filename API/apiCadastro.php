<?php 
    // // header da requisição http para declarar que a resposta será um json
    // header("Content-Type: application/json");

    // classe PDO para realização de operações no BD
    require ("./Database.php");
    $db = new Database();

    // destructuring das variáveis recebidas pelo POST request
    [$nome, $email, $senha] = [$_POST["nome"], $_POST["email"], $_POST["senha"]];
    
    $result = $db->insertBasicUser($nome, $email, $senha);
    
    // tratamento das possíveis respostas de insertBasicUser
    if ($result === true) {
        $resposta = [ "resposta" => "usuario cadastrado" ];
    } else if ($result === "ja existe um usuario cadastrado com esse email") {
        $resposta = [ "resposta" => $result ];
    } else {
        $resposta = [ "resposta" => "falha no cadastro" ];
    }
    
    echo json_encode($resposta);
?>