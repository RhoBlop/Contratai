<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");

    if (!isset($_POST["email"], $_POST["senha"]) ) {
        echo json_encode([
            "resposta" => "Parâmetros errados da requisição POST"
        ]);
        exit();
    }

    session_start();
    // classe PDO para realização de operações no BD
    require ("./Database.php");
    $db = new Database();
    
    // destructuring das variáveis recebidas pelo POST request
    [$email, $senha] = [$_POST["email"], $_POST["senha"]];
    // retorna o id do usuário, caso exista um, ou "credenciais invalidas"
    $result = $db->selectUserLogin($email, $senha);
    
    // resposta da API  
    if (is_numeric($result)) {
        // se tudo der certo, $result é o id
        $_SESSION["idUsr"] = $result;
        $response = [ "resposta" => "sucesso no login"];
    } else if ($result === "credenciais invalidas") {
        $response = [ "resposta" => $result ];
    }

    echo json_encode($response);
?>