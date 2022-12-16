<?php

    $host = "kesavan.db.elephantsql.com";
    $dbname = "aphiampg";
    $port = "5432";
    $dbuser = "aphiampg";
    $dbpassword = "cubgU9swQ4jDFG6hJUKzT_C5Z7VeO_NL";

    // $db_con = new PDO('pgsql:host= ' .$host .$dbname .$dbuser .$dppassword);

    $dsn =  "pgsql:host=" . $host . 
            ";port=" . $port . 
            ";dbname=" . $dbname . 
            ";user=" . $dbuser . 
            ";password=" . $dbpassword;

    $db_con = new PDO($dsn);

    $db_con->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    $db_con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


?>