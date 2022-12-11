<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../verificacoes.php");
    require ("../../utils.php");

    // termina o serviço caso alguma das variáveis não tenha sido enviada no POST
    verifyIsSetPost("nome", "email", "telefone", "nascimento", "bio");

    // termina o serviço caso alguma das variáveis esteja vazia
    verifyIsEmptyPost("nome", "email");

    session_start();
    // termina o serviço caso o usuário não esteja autenticado
    verifyIsAuthenticated();

    // o usuário pode acabar não preenchendo alguns campos em um formulário de update,
    // então substituímos eles por valores nulos
    $_POST = replaceEmptysForNulls($_POST);

    // classe PDO para realização de operações no BD
    require ("../../database/Usuario.php");
    $user = new Usuario();

    // destructuring das variáveis
    [$nome, $email, $nascimento, $telefone, $bio] = [$_POST["nome"], $_POST["email"], $_POST["nascimento"], $_POST["telefone"], $_POST["bio"]];

    // apenas se um arquivo foi enviado juntamente à requisição
    if ($_FILES["imgPerfil"]["name"] !== "") {
        $dir = "user_profile/";
        $imgs = uploadImgsToServer($dir, $_FILES);

        $imgPath = $imgs[0];
        $_SESSION["profileImg"] = $imgPath;
    } else {
        $imgPath = null;
    }

    if (isset($_POST["idUser"]) && $_SESSION["admin"] === true) {
        $idUser = $_POST["idUser"];
    } else {
        $idUser = $_SESSION['iduser'];
    }

    $result = $user->updateInfo($idUser, $nome, $email, $imgPath, $nascimento, $telefone, $bio);
    $_SESSION["username"] = $nome;

    $response = $result;

    echo json_encode($response);
?>