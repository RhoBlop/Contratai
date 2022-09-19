<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: application/json");
    require ("../../php/verificacoes.php");

    // termina o serviço caso alguma das variáveis não tenha sido enviada no POST
    verifyIsSetPost("nome", "email", "telefone", "nascimento", "bio");

    // termina o serviço caso alguma das variáveis esteja vazia
    verifyIsEmptyPost("nome", "email");

    session_start();
    // termina o serviço caso o usuário não esteja autenticado
    verifyIsAuthenticated();

    require ("../../php/utils.php");
    // o usuário pode acabar não preenchendo alguns campos em um formulário de update,
    // então substituímos eles por valores nulos
    $_POST = replaceEmptysForNulls($_POST);

    // classe PDO para realização de operações no BD
    require ("../../php/database/Usuario.php");
    $user = new Usuario();

    // destructuring das variáveis
    [$nome, $email, $nascimento, $telefone, $bio] = [$_POST["nome"], $_POST["email"], $_POST["nascimento"], $_POST["nascimento"], $_POST["bio"]];

    // apenas se um arquivo foi enviado juntamente à requisição
    if ($_FILES["imgPerfil"]["name"] !== "") {
        $imgs = generateImgBase64($_FILES);

        $imgBase64 = $imgs[0];
    } else {
        $imgBase64 = "";
    }

    $result = $user->updateInfo($_SESSION['idUsr'], $nome, $email, $imgBase64, $nascimento, $telefone, $bio);

    $response = $result;

    echo json_encode($response);
?>