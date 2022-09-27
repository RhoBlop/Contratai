<?php 
    require_once "Database.php";

    
    class Pesquisa extends Database {

        public function searchTable($search, $table, $limit = 1) {
            try {
                $allowedTables = ["usuario", "profissao"];
                
                if (in_array($table, $allowedTables)) {
                    $sql = <<<SQL
                        SELECT * FROM $table
                    SQL;
    
                    $stmt = Database::prepare($sql);
                    $stmt->execute();

                    $result = $stmt->fetchAll();
                    return ["dados" =>  $result];
                }
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }
    }
?>