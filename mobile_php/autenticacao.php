<?php

    $email = NULL;
    $senha = NULL;

    if ( isset( $_SERVER['PHP_AUTH_USER'] ) ) {
        $email = $_SERVER['PHP_AUTH_USER'];
        $senha = $_SERVER['PHP_AUTH_PW'];
    }
    elseif(isset( $_SERVER['HTTP_AUTHORIZATION'])) {
        if(preg_match( '//basic/i', $_SERVER['HTTP_AUTHORIZATION']))
            list($email, $senha) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
    }

    function autenticar($db_con) {
	
        
        $email = trim($GLOBALS['login']);
        $senha = trim($GLOBALS['senha']);
        
        if(!is_null($email)) {
            
            $consulta = $db_con->prepare("SELECT token FROM usuario WHERE login='$email'");
            $consulta->execute();

            if($consulta->rowCount() > 0){
                $linha = $consulta->fetch(PDO::FETCH_ASSOC);
                if(password_verify($senha, $linha['token'])){
                    return true;
                }
            }
        }
        return false;
    }

?>