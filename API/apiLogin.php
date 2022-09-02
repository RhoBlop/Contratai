<?php 
    session_start();

    // classe PDO para realização de operações no BD
    require ("./Database.php");
    $db = new Database();
    
    // destructuring das variáveis recebidas pelo POST request
    [$email, $senha] = [$_POST["email"], $_POST["senha"]];
    
    $result = $db->selectUserLogin($email, $senha);
?>