<?php
require_once "Database.php";
require_once "Notificacao.php";

class Contrato extends Database
{
    public function insertContrato($idContratante, $idContratado, $idEspec, $diasContrato)
    {
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

            foreach ($diasContrato as $data) {
                $stmt->execute([
                    ":idcontrato" => $idContrato,
                    ":diacontrato" => $data
                ]);
            }

            $conn->commit();

            return ["dados" => true];
        } catch (PDOException $e) {
            $conn->rollback();

            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function setStatusContrato($idcontrato, $idstatus)
    {
        try {
            $sql = <<<SQL
                    UPDATE contrato
                    SET idstatus = :idstatus
                    WHERE idcontrato = :idcontrato
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":idstatus" => $idstatus,
                ":idcontrato" => $idcontrato
            ]);

            return ["dados" => true];
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    /* ================================
                     CONTRATADO
                   (PROFISSIONAL)
           ================================ */

    public function selectContratosProfissional($idcontratante, $idstatus)
    {
        try {
            $sql = <<<SQL
                  SELECT contrt.idcontrato, idcontratante, json_agg(diacontrato) AS diascontrato, timecriacaocontrato, timefinalizacaocontrato, descrespec, usr.iduser, nomeuser, imguser
                  FROM contrato AS contrt
                  INNER JOIN diacontrato AS diacontrt ON (contrt.idcontrato = diacontrt.idcontrato)
                  INNER JOIN statuscontrato AS statcontrt ON (contrt.idStatus = statcontrt.idStatus)
                  INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                  INNER JOIN usuario AS usr ON (contrt.idcontratante = usr.iduser)
                  WHERE (contrt.idcontratado = :idcontratante) AND (contrt.idstatus = :idstatus)
                  GROUP BY contrt.idcontrato, descrespec, nomeuser, imguser, usr.iduser
              SQL;



            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":idcontratante" => $idcontratante,
                ":idstatus" => $idstatus
            ]);

            $result = $stmt->fetchAll();

            // converte json_agg() [String] para array associativa
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]["diascontrato"] = json_decode($result[$i]["diascontrato"]);
            }

            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }


    /* ================================
                     CONTRATANTE
                   (USUÁRIO NORMAL)
           ================================ */

    public function selectContratosContratante($idcontratante, $idstatus)
    {
        try {
            $sql = <<<SQL
                    SELECT contrt.idcontrato, idcontratado, json_agg(diacontrato) AS diascontrato, timecriacaocontrato, timefinalizacaocontrato, descrespec, usr.iduser, nomeuser, imguser
                    FROM contrato AS contrt
                    INNER JOIN diacontrato AS diacontrt ON (contrt.idcontrato = diacontrt.idcontrato)
                    INNER JOIN statuscontrato AS statcontrt ON (contrt.idStatus = statcontrt.idStatus)
                    INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                    INNER JOIN usuario AS usr ON (contrt.idcontratado = usr.iduser)
                    WHERE (contrt.idcontratante = :idcontratante) AND (contrt.idstatus = :idstatus)
                    GROUP BY contrt.idcontrato, descrespec, nomeuser, imguser, usr.iduser
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":idcontratante" => $idcontratante,
                ":idstatus" => $idstatus
            ]);

            $result = $stmt->fetchAll();

            // converte json_agg() [String] para array associativa
            // for ($i = 0; $i < count($result); $i++) {
            //     $result[$i]["diascontrato"] = json_decode($result[$i]["diascontrato"]);
            // }

            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }
}
