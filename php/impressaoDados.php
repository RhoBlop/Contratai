<?php
    // imprime o segundo parâmetro caso o primeiro seja nulo
    function echoDadosNotNull($value, $backupValue) {
        echo is_null($value) ? $backupValue : $value;
    }

    // substitui backslash por <br> para quebra de linhas no html
    function echoDadosBreakLine($text) {
        echo is_null($text) ? "---" : nl2br($text);
    }
    
    // formata data para dd/mm/yyyy
    function echoFormattedDate($date) {
        echo is_null($date) ? "---" : date("d/m/Y", strtotime($date));
    }

    // imprime a imagem de perfil padrão caso o parâmetro seja nulo
    function echoProfileImage($img) {
        echo is_null($img) ? "images/temp/default-pic.png" : $img;
    }

    // imprime a classe de acordo com a nota da avaliação
    function echoAvaliacaoClass($nota) {
        echo $nota > 4.5 ? "avaliacao-otima" : "avaliacao-media";
    }
    
?>