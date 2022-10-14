<?php 
    require_once "Database.php";
    
    class Pesquisa extends Database {

        public function searchUser($search, $limit = 1, $offset = 0) {
            try {
                $search = "{$search}%";

                $sql = <<<SQL
                    SELECT usr.iduser, nomeuser, imguser, datacriacaouser, round(avg(notaavaliacao), 1) AS mediaavaliacao, count(contrt.idcontrato) AS numcontrato, json_agg(espec.descrespec) AS especsuser
                    FROM usuario AS usr
                    INNER JOIN userespec AS useres ON (usr.iduser = useres.iduser)
                    INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                    FULL OUTER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    FULL OUTER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE usr.nomeuser ILIKE :search OR espec.descrespec ILIKE :search
                    GROUP BY usr.iduser, nomeuser, imguser, datacriacaouser
                    ORDER BY mediaavaliacao DESC
                    LIMIT :limit
                    OFFSET :offset
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":search" => $search,
                    ":limit" => $limit,
                    ":offset" => $offset
                ]);

                $result = $stmt->fetchAll();

                // converte json_agg() [String] para array associativa
                for ($i=0; $i<count($result); $i++) {
                    $result[$i]["especsuser"] = json_decode($result[$i]["especsuser"]);
                }
                
                return ["dados"=>$result];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }
    }
?>