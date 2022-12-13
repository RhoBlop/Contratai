<?php 
    require_once "Database.php";
    
    class Pesquisa extends Database {

        public function searchUser($search, $limit = 1, $offset = 0) {
            try {
                $search = "{$search}%";

                $sql = <<<SQL
                    SELECT top.iduser, nomeuser, imguser, datacriacaouser, array_to_json(especsuser) AS especsuser, round(avg(notaavaliacao), 1) AS mediaavaliacao, count(contrt.idcontrato) AS numcontrato
                    FROM ( SELECT usr.iduser, nomeuser, imguser, datacriacaouser, array_agg(espec.descrespec) AS especsuser
                        FROM usuario AS usr
                        INNER JOIN userespec AS useres ON (usr.iduser = useres.iduser)
                        INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                        WHERE usr.nomeuser ILIKE :search OR espec.descrespec ILIKE :search
                        GROUP BY usr.iduser, nomeuser, imguser, datacriacaouser
                    ) AS top
                    LEFT JOIN contrato AS contrt ON (top.iduser = contrt.idcontratado AND contrt.idstatus = 4)
                    LEFT JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY top.iduser, nomeuser, imguser, datacriacaouser, especsuser
                    ORDER BY mediaavaliacao DESC NULLS LAST
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
                
                return ["dados"=> $result];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }

        public function searchProf($search, $limit = 1, $offset = 0) {
            try {
                $search = "{$search}%";

                $sql = <<<SQL
                    SELECT top.idprof, descrprof, imgprof, array_to_json(especsprof) AS especsprof, round(avg(notaavaliacao), 1) AS mediaavaliacao
                    FROM ( SELECT prof.idprof, descrprof, imgprof, array_agg(espec.descrespec) AS especsprof
                        FROM profissao AS prof
                        INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                        WHERE prof.descrprof ILIKE :search OR espec.descrespec ILIKE :search
                        GROUP BY prof.idprof, descrprof, imgprof
                    ) AS top
                    INNER JOIN especializacao AS espec ON (top.idprof = espec.idespec)
                    LEFT JOIN contrato AS contrt ON (espec.idespec = contrt.idespec AND contrt.idstatus = 4)
                    LEFT JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY top.idprof, descrprof, imgprof, especsprof
                    ORDER BY mediaavaliacao DESC NULLS LAST
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
                    $result[$i]["especsprof"] = json_decode($result[$i]["especsprof"]);
                }
                
                return ["dados"=> $result];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }
    }
?>