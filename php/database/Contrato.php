<?php
require_once "Database.php";


class Contrato extends Database
{
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
            //TODO - inserir os dados no texto diretamente no insert da notificação?
            $this->insertNotificacao($solicitacaoStatus, $idContrato, $idContratante, $idContratado, $idEspec);

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

            if ($idstatus == 4) {
                $sql = <<<SQL
                    UPDATE contrato
                    SET timefinalizacaocontrato = :timestamp
                    WHERE idcontrato = :idcontrato
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":idstatus" => $idstatus,
                    ":idcontrato" => $idcontrato,
                    ":timestamp" => getCurrentTimestamp()
                ]);
            }

            return ["dados" => true];
        } catch (PDOException $e) {
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
                SQL;
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ":idcontrato" => $idContrato
                ]);
    
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

    public function insertNotificacao($idstatus, $idContrato, $idRemetente, $idDestinatario, $idEspec) {
        try {
            [$nomeuser, $descrespec] = $this->selectUsuarioAndEspec($idDestinatario, $idEspec);
            switch ($idstatus) {
                case 1:
                    $titleNotific = "Nova solicitação de contrato";
                    $descrNotific = "O usuário {1} solicitou você para um contrato de {2}";
                    break;
                case 2:
                    break;
            }

            $sql = <<<SQL
                    INSERT INTO notificacaoContrato(idContrato, idRemetente, idDestinatario, titleNotific, descrNotific, timeCriacaoNotific)
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

    public function selectNotificacoesDropdown($idUser) {
        try {
            $sql = <<<SQL
                    SELECT *
                    FROM usuario AS usr
                    INNER JOIN notificacaocontrato as notific ON (usr.iduser = notific.iddestinatario)
                    INNER JOIN contrato as contrt ON (notific.idcontrato = contrt.idcontrato)
                    WHERE (notific.iddestinatario = :id) AND (isvisualizado = FALSE);
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":id" => $idUser
            ]);

            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function selectUsuarioAndEspec($idUser, $idEspec) {
        $sql = <<<SQL
            SELECT nomeuser, descrespec
            FROM usuario AS usr
            CROSS JOIN especializacao AS espec
            WHERE iduser = :iduser AND idespec = :idespec
        SQL;

        $stmt = Database::prepare($sql);
        $stmt->execute([
            ":iduser" => $idUser,
            ":idespec" => $idEspec
        ]);

        [$nomeuser, $descrespec] = $stmt->fetch();

        return [$nomeuser, $descrespec];
    }
}
?>