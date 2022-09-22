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
    require ("../php/database/Usuario.php");
    $user = new Usuario();
    
    // destructuring das variáveis recebidas pelo POST request
    [$email, $senha] = [$_POST["email"], $_POST["senha"]];
    // retorna o id do usuário, caso exista um, ou "credenciais invalidas"
    $result = $user->selectLogin($email, $senha);


    if (isset($result["dados"])) {
        $idUsr = $result["dados"]["idusr"];
        $_SESSION["idUsr"] = $idUsr;
    }

    echo json_encode($result);
?>