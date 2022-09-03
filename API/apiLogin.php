<?php 
    session_start();

    // classe PDO para realização de operações no BD
    require ("./Database.php");
    $db = new Database();
    
    // destructuring das variáveis recebidas pelo POST request
    [$email, $senha] = [$_POST["email"], $_POST["senha"]];
    
    // retorna o id do usuário, caso exista um, ou "credenciais invalidas"
    $result = $db->selectUserLogin($email, $senha);
    
    if (is_numeric($result)) {
        // se tudo der certo, $result é o id
        $_SESSION["idusr"] = $result;
        $response = [ "resposta" => "sucesso no login"];
    } else if ($result === "credenciais invalidas") {
        $response = [ "resposta" => $result ];
    }

    echo json_encode($response);
?>