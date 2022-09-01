<?php 
    class Database {
        private $dsn = "pgsql:host=fanny.db.elephantsql.com;port=5432;dbname=fiutwocm";
        private $username = "fiutwocm";
        private $password = "CaP72wiKK6956Kts5JGBHg8VyxOSimyS";
        private $connection;

        public function __construct() {
            try {
                $this->connection = new PDO($this->dsn, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        }

        public function selectFromTable($table) {
            $sql = "SELECT * FROM usuario";
            $stmt = $this->connection->query($sql);
            // $stmt->execute([]);
            
            foreach($stmt as $row) {
                print_r($row);
            }
        }
    }

    $db = new Database();
    $db->selectFromTable("usuario");
?>