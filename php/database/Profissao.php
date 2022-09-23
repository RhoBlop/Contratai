<?php 
    class Profissao {
        protected $table = "profissao";

        // retorna
        public function selectMaisContratos($limit) {
            try {
                $sql = <<<SQL
                    SELECT count(*) AS numProf, avg(notaAvaliacao) AS mediaAvaliacao, dscProf
                    FROM profissao AS prof
                    INNER JOIN especializacao AS espec ON (prof.idprof = espec.idprof)
                    INNER JOIN usrEspec AS usres ON (espec.idespec = usres.idespec)
                    INNER JOIN usuario AS usr ON (usres.idusr = usr.idusr)
                    INNER JOIN contrato AS contrato ON (espec.idespec = contrato.idespec)
                    INNER JOIN avaliacao as avaliacao ON (contrato.idcontrato = avaliacao.idcontrato)
                    GROUP BY prof.idProf
                    ORDER BY count(*) DESC
                    LIMIT :limit
                SQL;
                
                $stmt = Database::prepare($sql);
                $stmt->execute([ ":limit" => $limit ]);

                return $stmt->fetchAll();
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
?>