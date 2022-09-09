<?php
    require "../../php/Database.php";
    $db = new Database();

    print_r(json_encode($db->selectUserById(1)));
?>