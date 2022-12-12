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
                    SELECT contrt.idcontrato, notific.idnotific, idremetente, iddestinatario, timecriacaonotific, notific.idstatus, contrt.descrcontrato, remet.nomeuser, espec.descrespec, isvisualizado
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
                $naoVisualizado = [];
                $visualizado = [];

                foreach ($notificacoes as $notific) {
                    $title = null;
                    $text = null;
                    switch($notific["idstatus"]) {
                        case 1:
                            $title = "Nova solicitação de contratação";
                            $text = "{$notific["nomeuser"]} quer te contratar como {$notific["descrespec"]}!";
                            break;
                        case 2:
                            $title = "Contrato em andamento";
                            $text = "{$notific["nomeuser"]} aceitou seu contrato!";
                            break;
                        case 3:
                            $title = "Finalização de contrato";
                            $text = "{$notific["nomeuser"]} solicitou o fim de um contrato.";
                            break;
                        case 4:
                            $title = "Contrato finalizado";
                            $text = "{$notific["nomeuser"]} aceitou o fim do contrato!";
                            break;
                        case 5:
                            $title = "Contrato recusado";
                            $text = "{$notific["nomeuser"]} recusou seu contrato. Não desanime, existem mais oportunidades em nossa plataforma!";
                            break;
                        case 6:
                            $title = "Contrato atrasado";
                            $text = "O contrato com {$notific["nomeuser"]} está atrasado.";
                            break;
                        case (-1):
                            // criei esse status aqui, não existe em nenhum outro lugar
                            $title = "Contrato avaliado";
                            $text = "{$notific["nomeuser"]} avaliou sua contratação!";
                            break;
                        default:
                            $title = "Houve algum problema";
                            $text = "";
                            break;
                    }

                    if (!is_null($title) && !is_null($text)) {
                        $isVisualizado = $notific["isvisualizado"];
                        $notificData = [
                            "idnotific" => $notific["idnotific"],
                            "title" => $title,
                            "text" => $text,
                            "descrcontrato" => $notific["descrcontrato"],
                            "timecriacao" => $notific["timecriacaonotific"],
                            "visualizado" => $isVisualizado
                        ];
                        
                        if (!$isVisualizado) {
                            array_unshift($naoVisualizado, $notificData);
                        } else {
                            array_unshift($visualizado, $notificData);
                        }
                    }
                }
                
                $this->setVisualizedNotifics($idUser);
                return [$naoVisualizado, $visualizado];
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

        public function deleteNotificacao($idNotific) {
            try {
                $sql = <<<SQL
                        DELETE FROM notificacaocontrato WHERE idnotific = :id
                    SQL;
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $idNotific
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