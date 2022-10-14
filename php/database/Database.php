<?php 

// classe que controla a conexão com o banco de dados
class Database {
    private static $host = "jelani.db.elephantsql.com";
    private static $port = "5432";
    private static $dbname = "vrhxmjgv";
    private static $user = "vrhxmjgv";
    private static $password = "7Y_li5Y6yiSmQ7yupEe9B1UJ0F49Lfdw";
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
};

?>