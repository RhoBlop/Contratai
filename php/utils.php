<?php 
    // checa se o id do usuário está setado na sessão
    function isAuthenticated() {
        if (isset($_SESSION["idUsr"])) {
            return true;
        } else {
            return false;
        }
    }

    function replaceEmptysForNulls($array) {
        if (is_array($array)) {
            return array_map(function($value) {
                // se for vazio, retorna NULL, caso contrário retorna o próprio valor
                return $value === "" ? null : $value;
            }, $array);
        }
    }

    function logout() {
        session_unset();
        session_destroy();
        $_SESSION = array();
    }
?>