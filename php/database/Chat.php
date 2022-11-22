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
                $contacts = [];

                $sql = <<<SQL
                    SELECT iduser, nomeuser, imguser, textoMensagem, timeCriacaoMensagem
                    FROM (
                        SELECT usr.iduser, usr.nomeuser, usr.imguser, textoMensagem, timeCriacaoMensagem,
                            row_number() OVER (PARTITION BY usr.iduser ORDER BY timeCriacaoMensagem DESC) AS rn
                        FROM usuario AS usr
                        INNER JOIN mensagem AS msg ON (usr.iduser = msg.idremetente)
                        WHERE msg.iddestinatario = :idreceiver
                    ) AS t
                    WHERE rn = 1
                    ORDER BY timeCriacaoMensagem DESC
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":idreceiver" => $this->idUser
                ]);

                foreach ($stmt->fetchAll() AS $row) {
                    $contact = [
                        "idUser" => $row["iduser"],
                        "userName" => $row["nomeuser"],
                        "imgUser" => $row["imguser"],
                        "lastMessage" => $row["textomensagem"],
                        "timestamp" => $row["timecriacaomensagem"]
                    ];
                    $contacts[] = $contact;
                }

                $result = [
                    "idUser" => $this->idUser,
                    "contacts" => $contacts
                ];
    
                return [ "dados" => $result ];
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();

                return ["dados" => false];
            }
        }

        public function getNewUser($idUserContact) {
            try {
                $SQL = <<<SQL
                    SELECT iduser, nomeuser, imguser
                        FROM usuario
                        WHERE iduser = :idDestinatario
                SQL;
                $stmt = Database::prepare($SQL);
                $stmt->execute([
                    ":idDestinatario" => $idUserContact
                ]);

                $user = $stmt->fetch();
                $result = [
                    "idUser" => $user['iduser'],
                    "userName" => $user['nomeuser'],
                    "imgUser" => $user['imguser'],
                    "lastMessage" => "Nenhuma mensagem",
                    "timestamp" => getCurrentTimestamp()
                ];

                return [ "dados" => $result ];
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();

                return ["dados" => false];
            }
        }

        public function getContactMessages($idUserContact, $limit, $offset) {
            try {
                $messages = [];

                $sql = <<<SQL
                    SELECT sender.iduser as "idSender", receiver.iduser as "idReceiver", textoMensagem, timecriacaomensagem
                    FROM mensagem AS msg
                    INNER JOIN usuario AS sender ON (msg.idremetente = sender.iduser)
                    INNER JOIN usuario AS receiver ON (msg.iddestinatario = receiver.iduser)
                    WHERE ((msg.iddestinatario = :iduser) AND (msg.idremetente = :idUserContact)) OR
                          ((msg.iddestinatario = :idUserContact) AND (msg.idremetente = :iduser))
                    ORDER BY timecriacaomensagem
                    LIMIT :limit
                    OFFSET :offset
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":iduser" => $this->idUser,
                    ":idUserContact" => $idUserContact,
                    ":limit" => $limit,
                    ":offset" => $offset
                ]);

                foreach ($stmt->fetchAll() AS $row) {
                    $message = [
                        "text" => $row["textomensagem"],
                        "timestamp" => $row["timecriacaomensagem"],
                        "sent" => $this->idUser === $row["idSender"]
                    ];
                    $messages[] = $message;
                }
    
                return [ "dados" => $messages ];
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();

                return ["dados" => false];
            }
        }

        public function sendMessage($idReceiver, $msg, $timestamp) {
            try {
                if ($msg === "") {
                    return;
                }

                $mensagemSQL = <<<SQL
                    INSERT INTO mensagem(idremetente, iddestinatario, textoMensagem, timeCriacaoMensagem)
                    VALUES (:idRemetente, :idDestinatario, :msg, :timestamp)
                SQL;
                $mensagemSTMT = Database::prepare($mensagemSQL);
                $mensagemSTMT->execute([
                    ":idRemetente" => $this->idUser,
                    ":idDestinatario" => $idReceiver,
                    ":msg" => $msg,
                    ":timestamp" => $timestamp
                ]);

                return [ "dados" => true ];
            } catch (PDOException $e) {
                echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
                exit();

                return ["dados" => false];
            }
        }
    }

    // $chat = new Chat(1);
    // var_dump($chat->getContactMessages(2));
    // print_r($chat->sendMessage(2, "Nossa cara vou te dar um atiro amanhã"));

    // $chat = new Chat(2);
    // var_dump($chat->getContacts());
    // print_r($chat->sendMessage(1, "Vou fazer merda nenhuma não cara"));
?>

