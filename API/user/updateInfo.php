<?php 
    // header da requisição http para declarar que a resposta será um json
    header("Content-Type: multipart/form-data");

    // senha não é obrigatório
    if (!isset($_POST["nome"], $_POST["email"], $_POST["cpf"], $_POST["regiao"], $_POST["data"], $_POST["bio"]) ) {
        echo json_encode([
            "resposta" => "parametros errados da requisicao POST"
        ]);
        exit();
    }

    session_start();
    require("../../php/utils.php");
    if (!isAuthenticated()) {
        echo json_encode([ "resposta" => "nao autenticado" ]);
        exit();
    }
    // classe PDO para realização de operações no BD
    require ("../../php/Database.php");
    $db = new Database();

    // destructuring das variáveis
    [$nome, $email, $cpf, $regiao, $nascimento, $telefone, $bio] = [$_POST["nome"], $_POST["email"], $_POST["cpf"], $_POST["regiao"], $_POST["nascimento"], $_POST["data"], $_POST["bio"]];

    // apenas se um arquivo foi enviado juntamente à requisição
    if ($_FILES["imgUsr"]["name"] !== "") {
        // caminho de onde o servidor salvou a imagem temporariamente
        $tmpPath = $_FILES["imgUsr"]["tmp_name"];
        // dados da imagem
        $imgData = file_get_contents($tmpPath);
        // tipo da imagem
        $imgType = pathinfo($_FILES["imgUsr"]["name"], PATHINFO_EXTENSION);

        // tradução dos dados para base64
        $imgBase64 = "data:image/{$imgType};base64" . base64_encode($imgData);
    } else {
        $imgBase64 = null;
    }

    $result = $db->updateUserInfo($_SESSION['idUsr'], $nome, $email, $cpf, $imgBase64, $nascimento, $telefone, $bio);
?>