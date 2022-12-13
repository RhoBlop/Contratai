<?php
// imprime o segundo parâmetro caso o primeiro seja nulo
function echoDadosNotNull($value, $backupValue)
{
    echo is_null($value) ? $backupValue : $value;
}

// substitui backslash por <br> para quebra de linhas no html
function echoDadosBreakLine($text)
{
    echo is_null($text) ? "---" : nl2br($text);
}

// formata data para dd/mm/yyyy
function echoFormattedDate($date)
{
    echo is_null($date) ? "---" : date("d/m/Y", strtotime($date));
}

// 12 de outubro de 2022
function echoFullDate($date)
{
    $locale = "pt_BR";
    $dateType = IntlDateFormatter::LONG; //type of date formatting
    $timeType = IntlDateFormatter::NONE; //type of time formatting setting to none, will give you date itself
    $formatter = new IntlDateFormatter($locale, $dateType, $timeType);
    $dateTime = new DateTime($date);
    echo $formatter->format($dateTime);
}

function returnFullDate($date)
{
    $locale = "pt_BR";
    $dateType = IntlDateFormatter::LONG; //type of date formatting
    $timeType = IntlDateFormatter::NONE; //type of time formatting setting to none, will give you date itself
    $formatter = new IntlDateFormatter($locale, $dateType, $timeType);
    $dateTime = new DateTime($date);
    return $formatter->format($dateTime);
}

// 12 de out. de 2022
function echoMediumDate($date)
{
    $locale = "pt_BR";
    $dateType = IntlDateFormatter::MEDIUM; //type of date formatting
    $timeType = IntlDateFormatter::NONE; //type of time formatting setting to none, will give you date itself
    $formatter = new IntlDateFormatter($locale, $dateType, $timeType);
    $dateTime = new DateTime($date);
    echo $formatter->format($dateTime);
}

// imprime a imagem de perfil padrão caso o parâmetro seja nulo
function echoProfileImage($img)
{
    echo is_null($img) ? "images/temp/default-pic.png" : $img;
}


//mesma ideia da impressão de foto de perfil, só que com os banners de carrossel das profissões 
function echoProfissaoImage($img) 
{
    echo is_null($img) ? "images/temp/placeholder-card.jpg" : $img;
}

// imprime a classe de acordo com a nota da avaliação
function echoAvaliacaoClass($nota)
{
    echo $nota > 4.5 ? "avaliacao-otima" : "avaliacao-media";
}
