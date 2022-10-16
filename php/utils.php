<?php
function logout()
{
    session_unset();
    session_destroy();
    $_SESSION = array();
}

// gera base64 das imagens, variável $_FILES passada por parâmetro
function generateImgBase64($files)
{
    $imgs = [];

    foreach ($files as $f) {
        // caminho da imagem salva temporariamente no servidor
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
function replaceEmptysForNulls($array)
{
    if (is_array($array)) {
        return array_map(function ($value) {
            // se for vazio, retorna NULL, caso contrário retorna o próprio valor
            return $value === "" ? null : $value;
        }, $array);
    }
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'ano',
        'm' => 'mês',
        'w' => 'semana',
        'd' => 'dia',
        'h' => 'hora',
        'i' => 'minuto'
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            // lida com plural
            if ($diff->$k > 1) {
                if ($k === 'm') {
                    $v = $diff->$k . ' ' . 'meses';
                } else {
                    $v = $diff->$k . ' ' . $v . 's';
                }
            } else {
                $v = $diff->$k . ' ' . $v;
            }
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? 'Há ' . implode(', ', $string) : 'Agora mesmo';
}
