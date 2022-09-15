<?php 

// classe que controla a conexão com o banco de dados
class Database {
    private static $conn;  // connection

    public static function getInstance() {
        if (!isset(self::$conn)) {
            try {
                $dsn = "pgsql:host=fanny.db.elephantsql.com;port=5432;dbname=fiutwocm;user=fiutwocm;password=CaP72wiKK6956Kts5JGBHg8VyxOSimyS";
                self::$conn = new PDO($dsn);

                // faz com que o PDO lance uma PDOException em qualquer problema que acontecer (teoricamente) 
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Conexão falhou: {$e->getMessage()}"]);
            }
        }

        return self::$conn;
    }

    public static function prepare($sql) {
        return self::getInstance()->prepare($sql);
    }
};

?>