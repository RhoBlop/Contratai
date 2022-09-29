<?php 
    require_once "Database.php";

    
    class Pesquisa extends Database {

        public function searchUser($search, $limit = 1, $offset = 0) {
            try {
                $search = "%{$search}%";

                $sql = <<<SQL
                    SELECT usr.idusr, usr.nomusr, usr.imgusr, media.mediaavaliacao, media.numcontrato, json_agg(espec.dscespec) AS especsusr
                    FROM (SELECT usr.idusr, usr.nomusr, usr.imgusr
                          FROM usuario AS usr
                          INNER JOIN usrespec AS usres ON (usr.idusr = usres.idusr)
                          INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                          WHERE usr.nomusr ILIKE :search OR espec.dscespec ILIKE :search
                          GROUP BY usr.idusr, usr.nomusr, usr.imgusr
                        ) AS usr
                    INNER JOIN (SELECT usr.idusr, round(avg(notaavaliacao), 1) AS mediaavaliacao, count(*) AS numcontrato
                          FROM usuario AS usr
                          INNER JOIN usrespec AS usres ON (usr.idusr = usres.idusr)
                          INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                          INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                          INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                          GROUP BY usr.idusr
                        ) AS media ON (usr.idusr = media.idusr)
                    INNER JOIN usrespec AS usres ON (usr.idusr = usres.idusr)
                    INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                    GROUP BY usr.idusr, usr.nomusr, usr.imgusr, media.mediaavaliacao, media.numcontrato
                    ORDER BY media.mediaavaliacao DESC
                    LIMIT :limit
                    OFFSET :offset
                SQL;

                /* SELECT top.idusr, top.nomusr, top.imgusr, top.mediaavaliacao, top.numcontrato, json_agg(espec.dscespec) AS especsusr
                    FROM (SELECT usr.idusr, usr.nomusr, usr.imgusr, round(avg(notaavaliacao), 1) AS mediaavaliacao, count(*) AS numcontrato
                          FROM usuario AS usr
                          INNER JOIN usrespec AS usres ON (usr.idusr = usres.idusr)
                          INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                          INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                          INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                          WHERE top.nomusr ILIKE :search OR espec.dscespec ILIKE :search
                          GROUP BY usr.idusr, usr.nomusr, usr.imgusr
                          ORDER BY mediaavaliacao DESC
                          LIMIT :limit
                          OFFSET :offset
                          ) AS top
                    INNER JOIN usrespec AS usres ON (top.idusr = usres.idusr)
                    INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                    GROUP BY top.idusr, top.nomusr, top.imgusr, top.mediaavaliacao, top.numcontrato
                */
                
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":search" => $search,
                    ":limit" => $limit,
                    ":offset" => $offset
                ]);

                $result = $stmt->fetchAll();

                return ["dados"=>$result];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }
    }
?>