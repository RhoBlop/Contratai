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
    require ("../database/Usuario.php");
    $user = new Usuario();
    
    // destructuring das variáveis recebidas pelo POST request
    [$email, $senha] = [$_POST["email"], $_POST["senha"]];
    // retorna o id do usuário, caso exista um
    $result = $user->selectLogin($email, $senha);


    if (isset($result["dados"])) {
        $iduser = $result["dados"]["iduser"];
        $_SESSION["iduser"] = $iduser;

        $admin = $result["dados"]["isadminuser"];
        $_SESSION["admin"] = $admin;

        $result = [
            "dados" => true
        ];
    }

    echo json_encode($result);
?>