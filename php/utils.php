<?php 
    function isAuthenticated() {
        if (isset($_SESSION["idUsr"])) {
            return true;
        } else {
            return false;
        }
    }
?>