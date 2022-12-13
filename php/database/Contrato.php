<?php
require_once "Database.php";
require_once "NotificacaoContrato.php";


class Contrato extends Database
{
    use NotificacaoContrato;

    public function insertContrato($idContratante, $idContratado, $idEspec, $descricao, $diasContrato)
    {
        $conn = Database::getInstance();

        $conn->beginTransaction();
        try {
            // idstatus = 1 é o estado de solicitação
            $solicitacaoStatus = 1;
            $contratoSQL = <<<SQL
                    INSERT INTO contrato(idcontratado, idcontratante, idespec, descrContrato, idstatus, timecriacaocontrato) VALUES
                    (:idcontratado, :idcontratante, :idespec, :descricao, :idstatus, :timestamp)
                    RETURNING idcontrato
                SQL;
            $stmt = $conn->prepare($contratoSQL);
            $stmt->execute([
                ":idcontratado" => $idContratado,
                ":idcontratante" => $idContratante,
                ":idespec" => $idEspec,
                ":descricao" => $descricao,
                ":idstatus" => $solicitacaoStatus,
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
            $this->insertNotificacao($idContrato, $idContratante, $idContratado, $solicitacaoStatus);

            $conn->commit();
            return ["dados" => true];
        } catch (PDOException $e) {
            $conn->rollback();
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function selectLegendaCalendario() {
        try {
            $sql = <<<SQL
                    SELECT descrstatus, corcalendario
                    FROM statuscontrato
                    ORDER BY idstatus
                SQL;
            
            $stmt = Database::prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function setStatusContrato($idContrato, $idStatus)
    {
        $conn = Database::getInstance();
        try {
            $conn->beginTransaction();
            // checar se o usuário realmente pode fazer essa alteração
            $sql = <<<SQL
                    UPDATE contrato
                    SET idstatus = :idstatus
                    WHERE idcontrato = :idcontrato
                    RETURNING idcontratante, idcontratado
                SQL;

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":idstatus" => $idStatus,
                ":idcontrato" => $idContrato
            ]);

            $fetch = $stmt->fetch();
            $remetente = null;
            $destinatario = null;

            switch ($idStatus) {
                case 2:
                    $remetente = $fetch["idcontratado"];
                    $destinatario = $fetch["idcontratante"];
                    break;

                case 3:
                    $remetente = $fetch["idcontratado"];
                    $destinatario = $fetch["idcontratante"];
                    break;

                case 4:
                    $remetente = $fetch["idcontratante"];
                    $destinatario = $fetch["idcontratado"];
                    // timestamp finalização do contrato
                    $sql = <<<SQL
                        UPDATE contrato
                        SET timefinalizacaocontrato = :timestamp
                        WHERE idcontrato = :idcontrato
                    SQL;
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ":idcontrato" => $idContrato,
                        ":timestamp" => getCurrentTimestamp()
                    ]);
                    break;

                case 5:
                    $remetente = $fetch["idcontratado"];
                    $destinatario = $fetch["idcontratante"];
                    break;

                case 6:
                    $this->insertNotificacao($idContrato, $fetch["idcontratante"], $fetch["idcontratado"], $idStatus);
                    $this->insertNotificacao($idContrato, $fetch["idcontratado"], $fetch["idcontratante"], $idStatus);
                    break;
            }

            if (!is_null($remetente) && !is_null($destinatario)) {
                $this->insertNotificacao($idContrato, $remetente, $destinatario, $idStatus);
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

    public function insertAvaliacao($idContrato, $idUser, $nota, $comentario) {
        $conn = Database::getInstance();

        $conn->beginTransaction();
        try {
            // verificar se quem está tentando avaliar realmente está no contrato
            $verifySQL = "SELECT idcontrato FROM contrato WHERE idContratante = :idUser";
            $verifyAvaliador = $conn->prepare($verifySQL);
            $verifyAvaliador->execute([":idUser" => $idUser]);

            if ($verifyAvaliador->rowCount() > 0) {
                $sql = <<<SQL
                        INSERT INTO Avaliacao(idContrato, notaAvaliacao, comentarioAvaliacao)
                        VALUES (:idcontrato, :nota, :comentario)
                    SQL;
    
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ":idcontrato" => $idContrato,
                    ":nota" => $nota,
                    ":comentario" => $comentario
                ]);

                $sql = <<<SQL
                    UPDATE contrato
                    SET isavaliado = TRUE
                    WHERE idcontrato = :idcontrato
                    RETURNING idcontratante, idcontratado
                SQL;
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ":idcontrato" => $idContrato
                ]);

                $fetch = $stmt->fetch();

                $this->insertNotificacao($idContrato, $fetch["idcontratante"], $fetch["idcontratado"], -1);
    
                $conn->commit();
                return ["dados" => true];
            } else {
                return ["dados" => false];
            }

        } catch (PDOException $e) {
            $conn->rollback();
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }
}
?>