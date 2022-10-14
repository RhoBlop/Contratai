<?php 
    // checa se o id do usuário está setado na sessão
    function verifyIsAuthenticated() {
        if (isset($_SESSION["iduser"])) {
            return true;
        } else {
            echo json_encode([ "resposta" => "nao autenticado" ]);
            exit();
        }
    }

    // recebe os valores esperados do POST como parâmetro e checa se eles realmente existem
    function verifyIsSetPost() {
        // recupera todos os argumentos passados para a função
        $args = func_get_args();

        foreach ($args as $val){
            if (!isset($_POST[$val])) {
                echo json_encode([
                    "resposta" => "parametros errados da requisicao POST"
                ]);
                exit();
            }
        }
    }

    // recebe os valores esperados do POST como parâmetro e checa se eles não estão vazio
    // (alguns precisam obrigatoriamente estarem preenchidos)
    function verifyIsEmptyPost() {
        // recupera todos os argumentos passados para a função
        $args = func_get_args();

        foreach ($args as $val) {
            if (empty($_POST[$val])) {
                echo json_encode([
                    "resposta" => "parametros vazios da requisicao POST"
                ]);
                exit();
            }
        }
    }
?>