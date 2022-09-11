<?php
    print_r($_POST);
    if ($_FILES["imgUsr"]["name"] !== "") {
        // caminho de onde o servidor salvou a imagem temporariamente
        $tmpPath = $_FILES["imgUsr"]["tmp_name"];
        // dados binários
        $imgData = file_get_contents($tmpPath);
        
        $imgType = pathinfo($_FILES["imgUsr"]["name"], PATHINFO_EXTENSION);
        $imgBase64 = "data:image/{$imgType};base64" . base64_encode($imgData);
    } else {
        $imgBase64 = null;
    }

    echo $imgBase64;
?>