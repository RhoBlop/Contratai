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

        public function selectNumNotificacoes($idUser) {
            try {
                $sql = <<<SQL
                    SELECT count(*) AS "numnotific"
                    FROM usuario AS usr
                    INNER JOIN notificacaocontrato as notific ON (usr.iduser = notific.iddestinatario)
                    INNER JOIN contrato as contrt ON (notific.idcontrato = contrt.idcontrato)
                    WHERE (notific.iddestinatario = :id) AND (isvisualizado = FALSE)
                SQL;
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $idUser
                ]);
    
                $result = $stmt->fetch();
                return $result;
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();
    
                return ["dados" => false];
            }
        }

        public function selectNotificacoes($idUser) {
            try {
                $sql = <<<SQL
                    SELECT contrt.idcontrato, idremetente, iddestinatario, timecriacaonotific, contrt.idstatus, remet.nomeuser, espec.descrespec
                    FROM usuario AS usr
                    INNER JOIN notificacaocontrato AS notific ON (usr.iduser = notific.iddestinatario)
                    INNER JOIN usuario AS remet ON (remet.iduser = notific.idremetente)
                    INNER JOIN contrato AS contrt ON (notific.idcontrato = contrt.idcontrato)
                    INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                    WHERE (notific.iddestinatario = :id)
                    ORDER BY timecriacaonotific ASC
                SQL;
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $idUser
                ]);

                $notificacoes = $stmt->fetchAll();
                $result = [];

                foreach ($notificacoes as $notific) {
                    switch($notific["idstatus"]) {
                        case 1:
                            $title = "Nova solicitação de contratação";
                            $text = "{$notific["nomeuser"]} quer te contratar para {$notific["descrespec"]}! Vá para a página de contratos para mais informações";
                            $result[] = [
                                "title" => $title,
                                "text" => $text,
                                "timecriacao" => $notific["timecriacaonotific"]
                            ];
                            break;
                    }
                }

                $this->setVisualizedNotifics($idUser);
                return $result;
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();
    
                return ["dados" => false];
            }
        }

        public function setVisualizedNotifics($idUser) {
            try {
                $sql = <<<SQL
                    UPDATE notificacaocontrato
                    SET isvisualizado = TRUE
                    WHERE iddestinatario = :id
                SQL;
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $idUser
                ]);
    
                $result = $stmt->fetch();
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

        public function insertNotificacao($idContrato, $idRemetente, $idDestinatario, $idstatus) {
            try {
                $sql = <<<SQL
                        INSERT INTO notificacaoContrato(idContrato, idRemetente, idDestinatario, idStatus, timeCriacaoNotific)
                        VALUES (:contrato, :remetente, :destinatario, :idstatus, :timestamp)
                    SQL;
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":contrato" => $idContrato,
                    ":remetente" => $idRemetente,
                    ":destinatario" => $idDestinatario,
                    ":idstatus" => $idstatus,
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