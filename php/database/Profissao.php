<?php 
    require_once "Database.php";

    
    class Profissao extends Database {
        protected $table = "profissao";
        
        // retorna
        public function selectMaisContratos($limit) {
            try {
                $sql = <<<SQL
                    SELECT count(*) AS numProf, dscProf
                    FROM (SELECT dscProf
                    FROM profissao AS prof
                    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                    INNER JOIN usrEspec AS usres ON (espec.idespec = usres.idespec)
                    INNER JOIN usuario AS usr ON (usres.idusr = usr.idusr)
                    GROUP BY prof.idProf
                    ORDER BY count(*) DESC
                    LIMIT :limit) as test
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":limit" => $limit ]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "action" => false ];
            }
        }

        // retorna as X profissões (de acordo com $limit) com maior média de avaliações 
        public function selectMaiorAvaliacao($limit) {
            
        }
    }
    $prof = new Profissao();
    $profissoes = $prof->selectMaisContratos(3);

    foreach($profissoes as $profi) {
        print_r($profi);
        echo "<br>";
    }
    ?>