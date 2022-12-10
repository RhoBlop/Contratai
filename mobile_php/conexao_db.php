<?php

    $host = "jelani.db.elephantsql.com";
    $dbname = "vrhxmjgv";
    $dbuser = "vrhxmjgv";
    $dppassword = "7Y_li5Y6yiSmQ7yupEe9B1UJ0F49Lfdw";

    $db_con = new PDO('pgsql: ' .$host .$dbname .$dbuser .$dppassword);

    $db_con->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    $db_con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


?>