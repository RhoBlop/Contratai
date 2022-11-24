<?php 
    trait NotificacaoContrato {
        public function selectNotificacoesDropdown($idUser) {
            try {
                $sql = <<<SQL
                        SELECT *
                        FROM usuario AS usr
                        INNER JOIN notificacaocontrato as notific ON (usr.iduser = notific.iddestinatario)
                        INNER JOIN contrato as contrt ON (notific.idcontrato = contrt.idcontrato)
                        WHERE ((notific.iddestinatario = :id) OR (notific.idremetente = :id)) AND (isvisualizado = FALSE)
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
    
        // public function selectUsuarioAndEspec($idUser, $idEspec) {
        //     $sql = <<<SQL
        //         SELECT nomeuser, descrespec
        //         FROM usuario AS usr
        //         CROSS JOIN especializacao AS espec
        //         WHERE iduser = :iduser AND idespec = :idespec
        //     SQL;
    
        //     $stmt = Database::prepare($sql);
        //     $stmt->execute([
        //         ":iduser" => $idUser,
        //         ":idespec" => $idEspec
        //     ]);
    
        //     [$nomeuser, $descrespec] = $stmt->fetch();
    
        //     return [$nomeuser, $descrespec];
        // }

        public function insertNotificacao($idContrato, $idRemetente, $idDestinatario) {
            try {
                $sql = <<<SQL
                        INSERT INTO notificacaoContrato(idContrato, idRemetente, idDestinatario, timeCriacaoNotific)
                        VALUES (:contrato, :remetente, :destinatario, :timestamp)
                    SQL;
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":contrato" => $idContrato,
                    ":remetente" => $idRemetente,
                    ":destinatario" => $idDestinatario,
                    ":timestamp" => getCurrentTimestamp()
                ]);
    
                return ["dados" => true];
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();
    
                return ["dados" => false];
            }
        }
    }
?>