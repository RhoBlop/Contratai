<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../../php/verificacoes.php");

    // termina o serviço caso alguma das variáveis não tenha sido enviada no POST
    verifyIsSetPost("nome", "email", "senha", "confirmSenha");

    // termina o serviço caso alguma das variáveis esteja vazia
    verifyIsEmptyPost("nome", "email", "senha", "confirmSenha");
    
    // classe PDO para realização de operações no BD
    require ("../../php/database/Usuario.php");
    $user = new Usuario();
    
    // destructuring das variáveis recebidas pelo POST request
    [$nome, $email, $senha, $confirmSenha] = [$_POST["nome"], $_POST["email"], $_POST["senha"], $_POST["confirmSenha"]];

    if ($senha == $confirmSenha) {
        $response = $user->insertBasicInfo($nome, $email, $senha);

        echo json_encode($response);
    }
?>