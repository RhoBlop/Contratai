<?php 
    require_once "Database.php";

    
    class Profissao extends Database {

        /* ================================
                       SELECTS
           ================================ */

        public function selectAll() {
            try {
                $sql = <<<SQL
                    SELECT idprof, descrprof FROM profissao
                SQL;

                $stmt = Database::prepare($sql);
                $stmt->execute();

                $result = $stmt->fetchAll();
                return [ "dados" => $result ];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }

        public function selectEspecs($idprof) {
            try {
                $sql = <<<SQL
                    SELECT prof.idprof, espec.idespec, descrespec
                    FROM profissao AS prof
                    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                    WHERE prof.idprof = :id
                    ORDER BY descrprof ASC
                SQL;

                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $idprof
                ]);

                $result = $stmt->fetchAll();
                return [ "dados" => $result ];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }

        public function selectProfissaoMaiorAvaliacao($idprof, $limit = 1) {
            try {
                $users = <<<SQL
                    SELECT prof.descrprof, espec.descrespec, usr.iduser, usr.nomeuser, usr.imguser, datacriacaouser, count(contrt.idcontrato) AS numContrato, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao
                    FROM usuario AS usr
                    INNER JOIN userEspec AS useres ON (usr.iduser = useres.iduser)
                    INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                    INNER JOIN profissao AS prof ON (espec.idprof = prof.idprof)
                    INNER JOIN contrato AS contrt ON (usr.iduser = contrt.idcontratado AND contrt.idespec = espec.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE (prof.idprof = :id)
                    GROUP BY usr.iduser, prof.descrprof, espec.descrespec
                    ORDER BY mediaavaliacao DESC
                    LIMIT :limit
                SQL;
                
                $stmt = Database::prepare($users);
                $stmt->execute([ 
                    ":id" => $idprof,
                    ":limit" => $limit 
                ]);

                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $users;
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }

        public function selectMaisCadastros($limit = 1) {
            try {
                $sql = <<<SQL
                    SELECT top.idprof, top.descrprof, top.numuser, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao 
                    FROM (SELECT count(*) AS numuser, prof.idprof, prof.descrProf
                        FROM profissao AS prof
                        INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                        INNER JOIN userespec AS useres ON (espec.idespec = useres.idespec)
                        INNER JOIN usuario AS usr ON (useres.iduser = usr.iduser)
                        GROUP BY prof.idprof, prof.descrProf
                        ORDER BY numuser DESC
                        LIMIT :limit) AS top
                    INNER JOIN especializacao AS espec ON (top.idprof = espec.idprof)
                    FULL OUTER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    FULL OUTER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY top.descrprof, top.numuser, top.idprof
                    ORDER BY top.numuser DESC;
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":limit" => $limit ]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }


        public function selectMaisContratos($limit = 1) {
            try {
                $sql = <<<SQL
                    SELECT top.idprof, top.descrprof, top.numContrato, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao
                    FROM (SELECT prof.idprof, prof.descrprof, count(contrt.idcontrato) AS numContrato
                        FROM profissao AS prof
                        INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                        INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                        GROUP BY prof.idprof, prof.descrprof
                        ORDER BY numContrato DESC
                        LIMIT :limit) AS top
                    INNER JOIN especializacao AS espec ON (top.idprof = espec.idprof)
                    FULL OUTER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    FULL OUTER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY top.descrprof, top.idprof, top.numContrato
                    ORDER BY top.numContrato DESC
                    LIMIT :limit
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":limit" => $limit ]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }


        // retorna as X profissões (de acordo com $limit) com maior média de avaliações 
        public function selectMaiorAvaliacao($limit = 1) {
            try {
                $sql = <<<SQL
                    SELECT prof.idprof, prof.descrprof, count(aval.idavaliacao) AS numAvaliacao, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao
                    FROM profissao AS prof
                    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                    INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY prof.descrprof, prof.idprof
                    ORDER BY mediaavaliacao DESC
                    LIMIT :limit
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":limit" => $limit ]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }
        /* ================================
                      /SELECTS
           ================================ */


        /* ================================
                       INSERTS
           ================================ */

        public function insertProf($descrProf) {
            try {
                $sql = <<<SQL
                    INSERT INTO profissao(descrProf) 
                    VALUES (:descrprof)
                    RETURNING idprof
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":descrprof" => $descrProf ]);

                $profId = $stmt->fetch()["idprof"];
                return ["dados" => $profId];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }

        public function insertEspec($profId, $descrEspec) {
            try {
                $sql = <<<SQL
                    INSERT INTO especializacao(idProf, descrEspec) 
                    VALUES (:idprof, :descrespec)
                    RETURNING idespec
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ 
                    ":idprof" => $profId,
                    ":descrespec" => $descrEspec 
                ]);

                $especId = $stmt->fetch()["idespec"];
                return ["dados" => $especId];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }
    }
    ?>