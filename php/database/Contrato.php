<?php 
    require_once "Database.php";
    require_once "Notificacao.php";

    class Contrato extends Database {
        public function insertContrato($idContratante, $idContratado, $idEspec, $diasContrato) {
            $conn = Database::getInstance();

            try {
                $conn->beginTransaction();

                // idstatus = 1 é o estado de solicitação
                $contratoSQL = <<<SQL
                    INSERT INTO contrato(idcontratado, idcontratante, idespec, idstatus) VALUES
                    (:idcontratado, :idcontratante, :idespec, 1)
                    RETURNING idcontrato
                SQL;
                $stmt = $conn->prepare($contratoSQL);
                $stmt->execute([
                    ":idcontratado" => $idContratado,
                    ":idcontratante" => $idContratante,
                    ":idespec" => $idEspec
                ]);
                
                $idContrato = $stmt->fetch()["idcontrato"];

                $diasContratoSQL = <<<SQL
                    INSERT INTO diacontrato(idcontrato, diacontrato) VALUES
                    (:idcontrato, :diacontrato)
                SQL;
                $stmt = $conn->prepare($diasContratoSQL);

                foreach($diasContrato as $data) {
                    $stmt->execute([
                        ":idcontrato" => $idContrato,
                        ":diacontrato" => $data
                    ]);
                }

                $conn->commit();

                return ["dados" => true];
            } catch (PDOException $e) {
                $conn->rollback();

                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }

        public function setStatusContrato($idcontrato, $idstatus) {

        }

        /* ================================
                     CONTRATADO
                   (PROFISSIONAL)
           ================================ */

        public function selectPedidosProfissional($iduser) {
          try {
              $sql = <<<SQL
                  SELECT *
                  FROM contrato AS contrt
                  INNER JOIN diacontrato AS diacontrt ON (contrt.idcontrato = diacontrt.idcontrato)
                  INNER JOIN statuscontrato AS statcontrt ON (contrt.idStatus = statcontrt.idStatus)
                  INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                  INNER JOIN usuario AS usr ON (contrt.idcontratante = usr.iduser)
                  WHERE contrt.idcontratado = :id
              SQL;

              $stmt = Database::prepare($sql);
              $stmt->execute([
                  ":id" => $iduser
              ]);

              $result = $stmt->fetchAll();
              return [ "dados" => $result ];
          } catch(PDOException $e) {
              echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
              exit();
              
              return [ "dados" => false ];
          }
        }

        public function selectAndamentoContratado() {

        }

        public function selectFinalizadosContratado() {

        }


        /* ================================
                     CONTRATANTE
                   (USUÁRIO NORMAL)
           ================================ */

        public function selectPedidosContratante() {

        }

        public function selectAndamentoContratante() {

        }

        public function selectFinalizadosContratante() {

        }
    }
?>