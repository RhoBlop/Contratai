<?php 
    require_once "Database.php";
    
    class Pesquisa extends Database {

        public function searchUser($search, $limit = 1, $offset = 0) {
            try {
                $search = "{$search}%";

                $sql = <<<SQL
                    SELECT usr.iduser, usr.nomuser, usr.imguser, media.mediaavaliacao, media.numcontrato, json_agg(espec.descrespec) AS especsuser
                    FROM (SELECT usr.iduser, usr.nomuser, usr.imguser
                          FROM usuario AS usr
                          INNER JOIN userespec AS useres ON (usr.iduser = useres.iduser)
                          INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                          WHERE usr.nomuser ILIKE :search OR espec.descrespec ILIKE :search
                          GROUP BY usr.iduser, usr.nomuser, usr.imguser
                        ) AS user
                    INNER JOIN (SELECT usr.iduser, round(avg(notaavaliacao), 1) AS mediaavaliacao, count(*) AS numcontrato
                          FROM usuario AS usr
                          INNER JOIN userespec AS useres ON (usr.iduser = useres.iduser)
                          INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                          INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                          INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                          GROUP BY usr.iduser
                        ) AS media ON (usr.iduser = media.iduser)
                    INNER JOIN userespec AS useres ON (usr.iduser = useres.iduser)
                    INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                    GROUP BY usr.iduser, usr.nomuser, usr.imguser, media.mediaavaliacao, media.numcontrato
                    ORDER BY media.mediaavaliacao DESC
                    LIMIT :limit
                    OFFSET :offset
                SQL;

                /* SELECT top.iduser, top.nomuser, top.imguser, top.mediaavaliacao, top.numcontrato, json_agg(espec.descrespec) AS especsuser
                    FROM (SELECT usr.iduser, usr.nomuser, usr.imguser, round(avg(notaavaliacao), 1) AS mediaavaliacao, count(*) AS numcontrato
                          FROM usuario AS usr
                          INNER JOIN userespec AS useres ON (usr.iduser = useres.iduser)
                          INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                          INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                          INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                          WHERE top.nomuser ILIKE :search OR espec.descrespec ILIKE :search
                          GROUP BY usr.iduser, usr.nomuser, usr.imguser
                          ORDER BY mediaavaliacao DESC
                          LIMIT :limit
                          OFFSET :offset
                          ) AS top
                    INNER JOIN userespec AS useres ON (top.iduser = useres.iduser)
                    INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                    GROUP BY top.iduser, top.nomuser, top.imguser, top.mediaavaliacao, top.numcontrato
                */
                
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