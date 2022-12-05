<?php
    require_once "Database.php";

    class Chat extends Database {
        public $idUser;

        public function __construct($idUser)
        {
            $this->idUser = $idUser;
        }

        public function getContacts($newUserId) {
            $conn = Database::getInstance();
            
            $conn->beginTransaction();
            try {
                $contacts = [];
                $insertedIds = [];

                $sql = <<<SQL
                    SELECT *
                    FROM (
                        SELECT sender.iduser as "idSender", sender.nomeuser as "nomeSender", sender.imguser "imgSender", receiver.iduser as "idReceiver", receiver.nomeuser "nomeReceiver", receiver.imguser "imgReceiver", textoMensagem, timeCriacaoMensagem,
                            CASE 
                                WHEN sender.iduser = :idchatowner 
                                    THEN row_number() OVER (PARTITION BY receiver.iduser ORDER BY timeCriacaoMensagem DESC)
                                WHEN receiver.iduser = :idchatowner 
                                    THEN row_number() OVER (PARTITION BY sender.iduser ORDER BY timeCriacaoMensagem DESC)
                            END AS rn
                        FROM mensagem AS msg
                        INNER JOIN usuario AS sender ON (msg.idremetente = sender.iduser)
                        INNER JOIN usuario AS receiver ON (msg.iddestinatario = receiver.iduser)
                        WHERE ((msg.iddestinatario = :idchatowner) OR (msg.idremetente = :idchatowner))
                    ) AS t
                    WHERE rn = 1
                    ORDER BY timeCriacaoMensagem DESC
                SQL;
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ":idchatowner" => $this->idUser
                ]);

                foreach ($stmt->fetchAll() AS $row) {
                    if (!in_array($row["idSender"], $insertedIds) && !in_array($row["idReceiver"], $insertedIds)) {
                        if ($row["idSender"] === $this->idUser) {
                            $sufix = "Receiver";
                            $insertedIds[] = $row["idReceiver"];
                        } else if ($row["idReceiver"] === $this->idUser) {
                            $sufix = "Sender";
                            $insertedIds[] = $row["idSender"];
                        }
                        $contact = [
                            "idUser" => $row["id{$sufix}"],
                            "userName" => $row["nome{$sufix}"],
                            "imgUser" => $row["img{$sufix}"],
                            "lastMessage" => $row["textomensagem"],
                            "timestamp" => $row["timecriacaomensagem"]
                        ];
                        $contacts[] = $contact;
                    }
                }

                // NEW CONTACT
                if ($newUserId !== null && is_numeric($newUserId)) {
                    $userExists = false;
                    for ($i = 0; $i < count($contacts); $i++) {
                        $cont = $contacts[$i];
                        if ($cont["idUser"] === $newUserId) {
                            // change contact order to first on array
                            $out = array_splice($array, $i, 1);
                            array_splice($array, 0, 0, $out);

                            $userExists = true;
                            break;
                        }
                    }

                    if (!$userExists) {
                        $sql = <<<SQL
                            SELECT iduser, nomeuser, imguser
                                FROM usuario
                                WHERE iduser = :newUser
                        SQL;
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([
                            ":newUser" => $newUserId
                        ]);
    
                        $user = $stmt->fetch();
                        $newContact = [
                            "idUser" => $user['iduser'],
                            "userName" => $user['nomeuser'],
                            "imgUser" => $user['imguser'],
                            "lastMessage" => "Nenhuma mensagem",
                            "timestamp" => getCurrentTimestamp()
                        ];

                        array_splice($contacts, 0, 0, [$newContact]);
                    }   
                }

                $result = [
                    "idUser" => $this->idUser,
                    "contacts" => $contacts
                ];
    
                $conn->commit();
                return [ "dados" => $result ];
            } catch (PDOException $e) {
                $conn->rollback();
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
?>

