<?php
require_once "Database.php";


class Contrato extends Database
{
    public function insertContrato($idContratante, $idContratado, $idEspec, $diasContrato)
    {
        $conn = Database::getInstance();

        try {
            $conn->beginTransaction();

            // idstatus = 1 é o estado de solicitação
            $contratoSQL = <<<SQL
                    INSERT INTO contrato(idcontratado, idcontratante, idespec, idstatus, timecriacaocontrato) VALUES
                    (:idcontratado, :idcontratante, :idespec, 1, :timestamp)
                    RETURNING idcontrato
                SQL;
            $stmt = $conn->prepare($contratoSQL);
            $stmt->execute([
                ":idcontratado" => $idContratado,
                ":idcontratante" => $idContratante,
                ":idespec" => $idEspec,
                ":timestamp" => getCurrentTimestamp()
            ]);

            $idContrato = $stmt->fetch()["idcontrato"];

            // DIAS CONTRATOS
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

            // NOTIFICACAO
            //TODO - inserir os dados no texto diretamente no insert da notificação?
            $this->insertNotificacao($idContrato, $idContratante, $idContratado, "Nova solicitação de contrato", "O usuário {1} solicitou você para um contrato de {2}");

            $conn->commit();
            return ["dados" => true];
        } catch (PDOException $e) {
            $conn->rollback();

            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function insertNotificacao($idContrato, $idRemetente, $idDestinatario, $titleNotific, $descrNotific) {
        try {
            $sql = <<<SQL
                    INSERT INTO notificacao(idContrato, idRemetente, idDestinatario, titleNotific, descrNotific, timeCriacaoNotific)
                    VALUES (:contrato, :remetente, :destinatario, :title, :descr, :timestamp)
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":contrato" => $idContrato,
                ":remetente" => $idRemetente,
                ":destinatario" => $idDestinatario,
                ":title" => $titleNotific,
                ":descr" => $descrNotific,
                ":timestamp" => getCurrentTimestamp()
            ]);

            return ["dados" => true];
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function insertAvaliacao($idContrato, $idUser, $nota, $comentario) {
        $conn = Database::getInstance();

        try {
            $conn->beginTransaction();
            
            // verificar se quem está tentando avaliar realmente está no contrato
            $verifySQL = "SELECT idcontrato FROM contrato WHERE idContratante = :idUser";
            $verifyAvaliador = $conn::prepare($verifySQL);
            $verifyAvaliador->execute([":idUser" => $idUser]);

            if ($verifyAvaliador->rowCount() > 0) {
                $sql = <<<SQL
                        INSERT INTO Avaliacao(idContrato, notaAvaliacao, comentarioAvaliacao)
                        VALUES (:idcontrato, :nota, :comentario)
                    SQL;
    
                $stmt = $conn::prepare($sql);
                $stmt->execute([
                    ":idcontrato" => $idContrato,
                    ":nota" => $nota,
                    ":comentario" => $comentario
                ]);

                $sql = <<<SQL
                    UPDATE contrato
                    SET isavaliado = TRUE
                    WHERE idcontrato = :idcontrato
                SQL;
    
                $conn->commit();
                return ["dados" => true];
            } else {
                return ["dados" => false];
            }

        } catch (PDOException $e) {
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
}
