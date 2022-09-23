<?php 
    function carregaUsuario() {
        global $userClass;
        $response = $userClass->selectById($_SESSION["idusr"]);

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

    function echoImage($img) {
        echo is_null($img) ? "images/temp/default-pic.png" : $img;
    }
?>