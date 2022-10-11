<?php 
    require_once "Database.php";
    require_once "Notificacao.php";

    class Contrato extends Database {
        /* ================================
                     CONTRATADO
                   (PROFISSIONAL)
           ================================ */

        public function selectPedidosProfissional($idusr) {
          try {
              $sql = <<<SQL
                  SELECT *
                  FROM contrato AS contrt
                  INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                  INNER JOIN usuario AS usr ON (contrt.idcontratante = usr.idusr)
                  WHERE contrt.idcontratado = :id
              SQL;

              $stmt = Database::prepare($sql);
              $stmt->execute([
                  ":id" => $idusr
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