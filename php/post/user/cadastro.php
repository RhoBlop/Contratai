<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../verificacoes.php");

    // termina o serviço caso alguma das variáveis não tenha sido enviada no POST
    verifyIsSetPost("nome", "email", "cpf", "telefone", "senha", "confirmaSenha");

    // termina o serviço caso alguma das variáveis esteja vazia
    verifyIsEmptyPost("nome", "email", "cpf", "telefone", "senha", "confirmaSenha");
    
    // classe PDO para realização de operações no BD
    require ("../../database/Usuario.php");
    $user = new Usuario();
    
    //TODO: adicionar verificação do CEP e insert no cadastro
    // destructuring das variáveis recebidas pelo POST request
    [$nome, $email, $cpf, $telefone, $senha, $confirmaSenha] = [$_POST["nome"], $_POST["email"], $_POST["cpf"], $_POST["telefone"], $_POST["senha"], $_POST["confirmaSenha"]];

    if ($senha == $confirmaSenha) {
        $response = $user->insertBasicInfo($nome, $email, $cpf, $telefone, $senha);

        echo json_encode($response);
    }
?>