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

        public function selectProfById($idprof) { 
            try {
                $sql = <<<SQL
                    SELECT prof.idprof, prof.descrprof, prof.imgprof 
                    FROM profissao AS prof
                    WHERE prof.idprof = :id 
                    ORDER BY descrprof
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
                    SELECT prof.descrprof, usr.iduser, usr.nomeuser, usr.imguser, datacriacaouser, count(contrt.idcontrato) AS numContrato, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao
                    FROM usuario AS usr
                    INNER JOIN userEspec AS useres ON (usr.iduser = useres.iduser)
                    INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                    INNER JOIN profissao AS prof ON (espec.idprof = prof.idprof)
                    INNER JOIN contrato AS contrt ON (usr.iduser = contrt.idcontratado AND contrt.idespec = espec.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE (prof.idprof = :id) AND (contrt.idstatus = 4)
                    GROUP BY usr.iduser, prof.descrprof
                    ORDER BY mediaavaliacao DESC
                    LIMIT :limit
                SQL;
                
                $stmt = Database::prepare($users);
                $stmt->execute([ 
                    ":id" => $idprof,
                    ":limit" => $limit 
                ]);

                $users = $stmt->fetchAll();

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
                    SELECT top.idprof, top.descrprof, top.numuser, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao, top.imgprof 
                    FROM (SELECT count(*) AS numuser, prof.idprof, prof.descrProf, prof.imgprof
                        FROM profissao AS prof
                        INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                        INNER JOIN userespec AS useres ON (espec.idespec = useres.idespec)
                        INNER JOIN usuario AS usr ON (useres.iduser = usr.iduser)
                        GROUP BY prof.idprof, prof.descrProf
                        ORDER BY numuser DESC
                        LIMIT :limit) AS top
                    INNER JOIN especializacao AS espec ON (top.idprof = espec.idprof)
                    INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE (contrt.idstatus = 4)
                    GROUP BY top.descrprof, top.numuser, top.idprof, top.imgprof
                    ORDER BY top.numuser DESC, mediaavaliacao DESC;
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":limit" => $limit ]);

                return $stmt->fetchAll();
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }


        public function selectMaisContratos($limit = 1) {
            try {
                $sql = <<<SQL
                    SELECT top.idprof, top.descrprof, top.numContrato, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao, top.imgprof
                    FROM (SELECT prof.idprof, prof.descrprof, count(contrt.idcontrato) AS numContrato, prof.imgprof
                        FROM profissao AS prof
                        INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                        INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                        WHERE contrt.idstatus = 4
                        GROUP BY prof.idprof, prof.descrprof
                        ORDER BY numContrato DESC
                        LIMIT :limit) AS top
                    INNER JOIN especializacao AS espec ON (top.idprof = espec.idprof)
                    INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE contrt.idstatus = 4
                    GROUP BY top.descrprof, top.idprof, top.numContrato, top.imgprof
                    ORDER BY top.numContrato DESC, mediaavaliacao DESC;
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":limit" => $limit ]);

                return $stmt->fetchAll();
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
                    SELECT prof.idprof, prof.descrprof, count(aval.idavaliacao) AS numAvaliacao, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao, prof.imgprof
                    FROM profissao AS prof
                    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                    INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE (contrt.idstatus = 4)
                    GROUP BY prof.descrprof, prof.idprof
                    ORDER BY mediaavaliacao DESC NULLS LAST
                    LIMIT :limit
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":limit" => $limit ]);

                return $stmt->fetchAll();
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

        public function updateProf($idProf, $descrProf, $imgPath) {
            try {
                // SQLs diferentes para não deixar a foto vazia no banco de dados
                if ($imgPath != null) {
                    $sql = <<<SQL
                        UPDATE profissao
                        SET descrprof = :descrProf,
                        imgprof = :imgPath
                        WHERE idprof = :id
                        SQL;

                    $stmt = Database::prepare($sql);
                    $stmt->execute([
                        ":id" => $idProf,
                        ":descrProf" => $descrProf,
                        ":imgPath" => $imgPath,  
                    ]);
                } else {
                    $sql = <<<SQL
                        UPDATE profissao
                        SET descrprof = :descrProf
                        WHERE idprof = :id
                        SQL;

                    $stmt = Database::prepare($sql);
                    $stmt->execute([
                        ":id" => $idProf,
                        ":descrProf" => $descrProf
                    ]);
                }


                return ["dados" => true];
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();
    
                return ["dados" => false];
            }
        }
    }
?>