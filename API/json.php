<?php
    // testando JSON input
    header("Content-Type: application/json");

    $json = json_decode(file_get_contents("php://input"), true);
?>