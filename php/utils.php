<?php

/**
 * Makes a call to an API and return its response JSON decoded.
 * 
 * @param string $method HTTP method to be used GET|POST|PUT.
 * @param string $url Url to be fetched.
 * @param array|bool $data (optional => defaults to false) Data to be sent.
 * 
 * @return array API response decoded to associative array.
 */
function callAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method) {
        case "GET":
            curl_setopt($curl, CURLOPT_HTTPGET, 1);
            break;
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return json_decode($result, true);
}

/**
 * Destroys session superglobal, effectively logging out.
 * 
 * @return null.
 */
function logout()
{
    session_unset();
    session_destroy();
    $_SESSION = array();
}

/**
 * Takes files as parameters and uploads them to provided directory inside images/uploaded/.
 * 
 * @param string $dir in which directory inside images/uploaded/ the images should be uploaded.
 * @param array $files $_FILES superglobal.
 * 
 * @return array array filled with image saved names.
 */
function uploadImgsToServer($id, $dir, $files) {
    $imgsPaths = [];
    $folderPath = "../../../images/uploaded/" . $dir;
    
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    $userFiles = glob($folderPath . $id . '_*.*');
    if ($userFiles) {
        foreach($userFiles as $f) {
            unlink($f);
        }
    }

    foreach ($files as $f) {
        // caminho da imagem salva temporariamente no servidor
        $tmpPath = $f["tmp_name"];
        $sourceProps = getimagesize($tmpPath);
        $fileNewName = $id . "_" . time() . "_" . uniqid();

        // extensão da imagem (sem o .) 
        $ext = pathinfo($f["name"], PATHINFO_EXTENSION);
        $imageType = $sourceProps[2];

        switch ($imageType) {
            case IMAGETYPE_PNG:
                $imageResourceId = imagecreatefrompng($tmpPath); 
                $targetLayer = imageResize($imageResourceId, $sourceProps[0], $sourceProps[1]);
                imagepng($targetLayer, $folderPath. $fileNewName. "_resized.". $ext, 20);
                break;
      
            case IMAGETYPE_GIF:
                $imageResourceId = imagecreatefromgif($tmpPath); 
                $targetLayer = imageResize($imageResourceId, $sourceProps[0], $sourceProps[1]);
                imagegif($targetLayer, $folderPath. $fileNewName. "_resized.". $ext, 20);
                break;
      
            case IMAGETYPE_JPEG:
                $imageResourceId = imagecreatefromjpeg($tmpPath); 
                $targetLayer = imageResize($imageResourceId, $sourceProps[0], $sourceProps[1]);
                imagejpeg($targetLayer, $folderPath. $fileNewName. "_resized.". $ext, 20);
                break;
      
            default:
                $fileNewName = null;
                break;
        }

        // move_uploaded_file($tmpPath, $folderPath. $fileNewName. ".". $ext);
        $imgsPaths[] = "images/uploaded/" . $dir . $fileNewName. "_resized.". $ext;
    }

    return $imgsPaths;
}

/**
 * Não vou mentir que só peguei da internet
 */
function imageResize($imageResourceId, $width, $height) {
    // Make a fixed Width & Height but it might make the image look longer or wider
    /*$targetWidth = 50;
    $targetHeight = 50;*/
    // Keep the Image Ratio of Width & Height
    $maxDim = 300;
    $ratio = $width/$height;
    if( $ratio > 1) {
        //$targetWidth = $maxDim;
        //$targetHeight = $maxDim/$ratio;
        $targetWidth = $width;
        $targetHeight = $height;
    } else {
        // $targetWidth = $maxDim*$ratio;
        // $targetHeight = $maxDim;
        $targetWidth = $width;
        $targetHeight = $height;
    }
    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
    return $targetLayer;
  }

/**
 * Takes files as parameters and converts them into base64.
 * 
 * @param array $files $_FILES superglobal populated with one or more files.
 * 
 * @return array array filled with base64 for each object in $files.
 */
function generateImgsBase64($files)
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

function base64Resize($base64) {
    $percent = 1;

    // Content type
    header('Content-Type: image/jpeg');

    $data = base64_decode($base64);
    $imString = imagecreatefromstring($data);
    $width = imagesx($imString);
    $height = imagesy($imString);
    $newWidth = $width * $percent;
    $newHeight = $height * $percent;

    $thumb = imagecreatetruecolor($newWidth, $newHeight);

    // Resize
    imagecopyresampled($thumb, $imString, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Opens buffer to store file
    ob_start();
    imagejpeg($thumb, null);
    $img = ob_get_clean();
    $base64 = base64_encode($img);

    return $base64;
}

/**
 * Returns current time in string SQL formatted
 * 
 * @return string String of current timestamp
 */
function getCurrentTimestamp() {
    $timestamp = date('Y-m-d H:i:s');
    return $timestamp;
}

function getFullDate($date) {
    $locale = "pt_BR";
    $dateType = IntlDateFormatter::LONG; //type of date formatting
    $timeType = IntlDateFormatter::NONE; //type of time formatting setting to none, will give you date itself
    $formatter = new IntlDateFormatter($locale, $dateType, $timeType);
    $dateTime = new DateTime($date);
    return $formatter->format($dateTime);
}

function getMediumDate($date) {
    $locale = "pt_BR";
    $dateType = IntlDateFormatter::MEDIUM; //type of date formatting
    $timeType = IntlDateFormatter::NONE; //type of time formatting setting to none, will give you date itself
    $formatter = new IntlDateFormatter($locale, $dateType, $timeType);
    $dateTime = new DateTime($date);
    return $formatter->format($dateTime);
}

/**
 * Returns true if date is past today
 * 
 * @param string $date SQL formatted string of certain date
 * 
 * @return boolean
 */
function isDateExpired($date) {
    $date = new DateTime($date);
    $now = new DateTime();

    return $date < $now;
}

/**
 * Replace empty values in associative array for nulls.
 * 
 * Used, for example, when updating values to BD (empty HTML inputs do not return null).
 * 
 * @param array $array array to have its values changed.
 * 
 * @return array newly created array with ("") changed for NULL.
 */
function replaceEmptysForNulls($array)
{
    if (is_array($array)) {
        return array_map(function ($value) {
            // se for vazio, retorna NULL, caso contrário retorna o próprio valor
            return $value === "" ? null : $value;
        }, $array);
    }
}

/**
 * Returns string with elapsed time since some date.
 * 
 * Creates messages like "2 hours ago" or "1 month ago".
 * 
 * @param string $datetime string formatted as DATE or TIMESTAMP value.
 * @param bool $full (optional => defaults to false) Defines if the full elapsed time should be returned or only the bigger Hierarchy (2 hours ago, 2 minutes, 38 seconds vs 2 hours ago)
 * 
 * @return string time elapsed
 */
function timeElapsedString($datetime, $full = false)
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
