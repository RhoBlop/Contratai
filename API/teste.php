<?php
    require("../php/Database.php");
    $db = new Database();

    $resp = $db->updateUserInfo(38, "Thiago N", "thiago.snow@gmail.com", "", "", "", "999999999");

    echo $resp;
?>