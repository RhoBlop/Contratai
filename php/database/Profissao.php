<?php 
    require_once "Database.php";

    
    class Profissao extends Database {

        /* ================================
                       SELECTS
           ================================ */

        public function selectAll() {
            try {
                $sql = <<<SQL
                    SELECT idprof, dscprof FROM profissao
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
                    SELECT prof.idprof, espec.idespec, dscespec
                    FROM profissao AS prof
                    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                    WHERE prof.idprof = :id
                    ORDER BY dscprof ASC
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
                    SELECT prof.dscprof, espec.dscespec, usr.idusr, usr.nomusr, usr.imgusr, count(*) AS numContrato, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao
                    FROM usuario AS usr
                    INNER JOIN usrEspec AS usres ON (usr.idusr = usres.idusr)
                    INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                    INNER JOIN profissao AS prof ON (espec.idprof = prof.idprof)
                    INNER JOIN contrato AS contrt ON (usr.idusr = contrt.idcontratado AND contrt.idespec = espec.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE (prof.idprof = :id)
                    GROUP BY usr.idusr, prof.dscprof, espec.dscespec
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
                    SELECT top.idprof, top.dscprof, top.numusr, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao 
                    FROM (SELECT count(*) AS numUsr, prof.idprof, prof.dscProf
                        FROM profissao AS prof
                        INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                        INNER JOIN usrEspec AS usres ON (espec.idespec = usres.idespec)
                        INNER JOIN usuario AS usr ON (usres.idusr = usr.idusr)
                        GROUP BY prof.idprof, prof.dscProf
                        ORDER BY numUsr DESC
                        LIMIT :limit) AS top
                    INNER JOIN especializacao AS espec ON (top.idprof = espec.idprof)
                    INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY top.dscprof, top.numusr, top.idprof
                    ORDER BY top.numusr DESC;
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
                    SELECT top.idprof, top.dscprof, top.numContrato, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao
                    FROM (SELECT prof.idprof, prof.dscprof, count(*) AS numContrato
                        FROM profissao AS prof
                        INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                        INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                        GROUP BY prof.idprof, prof.dscprof
                        ORDER BY numContrato DESC
                        LIMIT :limit) AS top
                    INNER JOIN especializacao AS espec ON (top.idprof = espec.idprof)
                    INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY top.dscprof, top.idprof, top.numContrato
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
                    SELECT prof.idprof, prof.dscprof, count(*) AS numAvaliacao, round(avg(aval.notaavaliacao), 1) AS mediaavaliacao
                    FROM profissao AS prof
                    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                    INNER JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY prof.dscprof, prof.idprof
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

        public function insertProf($dscProf) {
            try {
                $sql = <<<SQL
                    INSERT INTO profissao(dscProf) 
                    VALUES (:dscprof)
                    RETURNING idprof
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":dscprof" => $dscProf ]);

                $profId = $stmt->fetch()["idprof"];
                return ["dados" => $profId];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }

        public function insertEspec($profId, $dscEspec) {
            try {
                $sql = <<<SQL
                    INSERT INTO especializacao(idProf, dscEspec) 
                    VALUES (:idprof, :dscespec)
                    RETURNING idespec
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ 
                    ":idprof" => $profId,
                    ":dscespec" => $dscEspec 
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