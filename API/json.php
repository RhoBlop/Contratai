<?php
    // testando JSON input
    header("Content-Type: application/json");
    $body = file_get_contents("php://input");

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $json = json_decode($body);
    }
?>