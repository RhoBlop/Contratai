<?php 
    function carregaUsuario() {
        global $usuarioClass;
        $response = $usuarioClass->selectBasicInfoById($_SESSION["idusr"]);

        if (isset($response["dados"])) {
            $user = $response["dados"];

            return $user;
        } else {
            header("Location: 500Error.php");
            exit();
        }
    }

    function echoDadosPerfil($field) {
        echo is_null($field) ? "---" : $field;
    }

    function echoDadosForm($field) {
        echo is_null($field) ? null : $field;
    }

    function echoDadosBreakLine($text) {
        echo is_null($text) ? "---" : nl2br($text);
    }
    
    function echoFormattedDate($date) {
        echo is_null($date) ? "---" : date("d/m/Y", strtotime($date));
    }

    function echoProfileImage($img) {
        echo is_null($img) ? "images/temp/default-pic.png" : $img;
    }

    function echoAvaliacaoClass($nota) {
        echo $nota > 4.5 ? "avaliacao-otima" : "avaliacao-media";
    }

?>