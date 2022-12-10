<?php

    $login = NULL;
    $senha = NULL;

    // Método para extrair o login e senha via mod_php (Apache)
    if ( isset( $_SERVER['PHP_AUTH_USER'] ) ) {
        $email = $_SERVER['PHP_AUTH_USER'];
        $senha = $_SERVER['PHP_AUTH_PW'];
    }
// Método para demais servers
    elseif(isset( $_SERVER['HTTP_AUTHORIZATION'])) {
        if(preg_match( '//basic/i', $_SERVER['HTTP_AUTHORIZATION']))
            list($email, $senha) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
    }

// O método abaixo realiza o processo de autenticação. Ele retorna 
// true caso os parametros de login e senha estejam corretos
// false caso os parametros de login e senha estejam incorretos
    function autenticar($db_con) {
	
        // Quando dentro de uma função, para acessar variáveis globais no php é
        // necessário acessá-las via $GLOBALS.
        $email = trim($GLOBALS['login']);
        $senha = trim($GLOBALS['senha']);
        //$db_con = $GLOBALS['db_con'];
        
        // Verifica antes se o parâmetro de login foi enviado ao servidor
        if(!is_null($email)) {
            
            // realiza a consula no bd pelo usuário login
            $consulta = $db_con->prepare("SELECT token FROM usuario WHERE login='$email'");
            $consulta->execute();

            // caso o usuário exista, obtem-se o token de autenticação e 
            // o verifica junto a senha enviada ao servidor
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