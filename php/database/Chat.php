<?php
    require_once "Database.php";

    class Chat extends Database {
        public $idUser;

        public function __construct($idUser)
        {
            $this->idUser = $idUser;
        }

        public function getContacts() {
            try {
                $sql = <<<SQL
                    SELECT usr.iduser, usr.nomeuser, textoMensagem 
                    FROM usuario AS usr
                    INNER JOIN mensagem AS msg ON (usr.iduser = msg.iddestinatario)
                    WHERE msg.iddestinatario = :idreceiver
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":idreceiver" => $this->idUser
                ]);
    
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();

                return ["dados" => false];
            }
        }

        public function getContactMessages($idSender) {
            try {
                $sql = <<<SQL
                    SELECT usr.iduser, usr.nomeuser, textoMensagem, timecriacaomensagem
                    FROM usuario AS usr
                    INNER JOIN mensagem AS msg ON (usr.iduser = msg.iddestinatario)
                    WHERE (msg.iddestinatario = :idreceiver) AND (msg.idremetente = :idsender)
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":idreceiver" => $this->idUser,
                    ":idsender" => $idSender
                ]);
    
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();

                return ["dados" => false];
            }
        }

        public function sendMessage($idReceiver, $msg) {
            try {
                $mensagemSQL = <<<SQL
                    INSERT INTO mensagem(idremetente, iddestinatario, textoMensagem, timeCriacaoMensagem)
                    VALUES (:idRemetente, :idDestinatario, :msg, :timestamp)
                SQL;
                $mensagemSTMT = Database::prepare($mensagemSQL);
                $mensagemSTMT->execute([
                    ":idRemetente" => $this->idUser,
                    ":idDestinatario" => $idReceiver,
                    ":msg" => $msg,
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
