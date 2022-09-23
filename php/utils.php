<?php 
    function isAuthenticated() {
        if (isset($_SESSION["idusr"])) {
            return true;
        } else {
            return false;
        }
    }

    function logout() {
        session_unset();
        session_destroy();
        $_SESSION = array();
    }

    function generateImgBase64($files) {
        $imgs = [];

        foreach($files as $f) {
            // caminho salvo no servidor
            $tmpPath = $f["tmp_name"];

            // extensão da imagem (sem o .) 
            $imgType = pathinfo($f["name"], PATHINFO_EXTENSION);
            $allowedTypes = ["webp", "jpg", "jpeg", "png", "svg"];

            if (in_array($imgType, $allowedTypes)) {
                // dados da imagem
                $imgData = file_get_contents($tmpPath);

                // base64
                $imgBase64 = "data:image {$imgType};base64, " . base64_encode($imgData);
            } else {
                $imgBase64 = null;
            }

            $imgs[] = $imgBase64;
        }

        return $imgs;
    }

    // usado em updates, para que os campos ainda não cadastrados continuem como NULL no BD
    function replaceEmptysForNulls($array) {
        if (is_array($array)) {
            return array_map(function($value) {
                // se for vazio, retorna NULL, caso contrário retorna o próprio valor
                return $value === "" ? null : $value;
            }, $array);
        }
    }
?>