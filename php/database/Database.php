<?php 
date_default_timezone_set('America/Sao_Paulo');

// classe que controla a conexão com o banco de dados
class Database {
    private static $host = "kesavan.db.elephantsql.com";
    private static $port = "5432";
    private static $dbname = "aphiampg";
    private static $user = "aphiampg";
    private static $password = "cubgU9swQ4jDFG6hJUKzT_C5Z7VeO_NL";
    private static $conn;  // connection

    public static function getInstance() {
        if (!isset(self::$conn)) {
            try {
                $dsn =  "pgsql:host=" . self::$host . 
                        ";port=" . self::$port . 
                        ";dbname=" . self::$dbname . 
                        ";user=" . self::$user . 
                        ";password=" . self::$password;

                self::$conn = new PDO($dsn);

                // faz com que o PDO lance uma PDOException em qualquer problema que acontecer (teoricamente) 
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                // self::$conn->setAttribute(PDO::ATTR_PERSISTENT, true);
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Conexão falhou: {$e->getMessage()}"]);
                exit();
            }
        }

        return self::$conn;
    }

    public static function prepare($sql) {
        return self::getInstance()->prepare($sql);
    }

    // public static function close() {
    //     echo "conn closed";
    //     self::$conn = null;
    // }
};

?>