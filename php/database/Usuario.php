<?php
require_once "Database.php";

class Usuario extends Database
{

    //SECTION - SELECTS
    // retorna usuário com o id passado por parâmetro
    public function selectBasicInfoById($userId)
    {
        try {
            $sql = <<<SQL
                    SELECT *
                    FROM usuario
                    WHERE iduser = :id;
                SQL;
            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":id" => $userId
            ]);

            $result = $stmt->fetch();

            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }


    public function selectPerfilPublicoById($userId)
    {
        try {
            // tá feio :(
            $sql = <<<SQL
                    SELECT userinfo.iduser, round(avg(notaavaliacao), 1) AS mediaavaliacao, count(contrt.idcontrato) AS numcontrato, nomeuser, emailuser, cpfuser, imguser, nascimentouser, telefoneuser, biografiauser
                    FROM (SELECT usr.iduser, nomeuser, emailuser, cpfuser, imguser, nascimentouser, telefoneuser, biografiauser
                            FROM usuario AS usr
                            INNER JOIN userespec AS useres ON (useres.iduser = usr.iduser)
                            INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                            WHERE usr.iduser = :id
                            GROUP BY usr.iduser, nomeuser, emailuser, cpfuser, imguser, nascimentouser, telefoneuser, biografiauser
                    ) AS userinfo
                    LEFT JOIN contrato AS contrt ON (userinfo.iduser = contrt.idcontratado)
                    LEFT JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY userinfo.iduser, nomeuser, emailuser, cpfuser, imguser, nascimentouser, telefoneuser, biografiauser
                SQL;
            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":id" => $userId
            ]);

            $result = $stmt->fetch();

            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }


    // retorna usuário para login, ou seja, a partir de um email e uma senha
    public function selectLogin($email, $senha)
    {
        try {
            $sql = <<<SQL
                    SELECT iduser, isadminuser
                    FROM usuario 
                    WHERE (emailuser = :email) AND (senhauser = :senha)
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":email" => $email,
                ":senha" => $senha
            ]);

            $result = $stmt->fetch();
            if ($result) {
                // retorna ID do usuário
                return ["dados" => $result];
            } else {
                return ["erro" => "Email ou senha inválidos"];
            }
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }


    public function selectProfissoessById($userId)
    {
        try {
            $sql = <<<SQL
                    SELECT useres.iduserespec, descrprof, espec.idespec, descrespec
                    FROM usuario AS usr
                    INNER JOIN userespec AS useres ON (usr.iduser = useres.iduser)
                    INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                    INNER JOIN profissao AS prof ON (espec.idprof = prof.idprof)
                    WHERE usr.iduser = :id
                    ORDER BY descrprof ASC
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":id" => $userId
            ]);

            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }


    public function selectEspecsPerfPublicoById($userId)
    {
        try {
            $sql = <<<SQL
                    SELECT espec.idespec, descrespec, round(avg(notaavaliacao), 1) AS mediaavaliacao
                    FROM usuario AS usr
                    INNER JOIN userespec AS useres ON (usr.iduser = useres.iduser)
                    INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                    LEFT JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    LEFT JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE usr.iduser = :id
                    GROUP BY espec.idespec, descrespec
                    ORDER BY mediaavaliacao DESC NULLS LAST
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":id" => $userId
            ]);

            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }


    public function selectAvaliacoesById($userId, $filterNota = "DESC")
    {
        try {
            $sql = <<<SQL
                    SELECT usr.iduser, usr.nomeuser, espec.idespec, descrespec, imguser, comentarioavaliacao, round(notaavaliacao, 1) as notaavaliacao
                    FROM avaliacao AS aval
                    INNER JOIN contrato AS contrt ON (aval.idcontrato = contrt.idcontrato)
                    INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                    INNER JOIN usuario AS usr ON (contrt.idcontratante = usr.iduser)
                    WHERE contrt.idcontratado = :id
                    ORDER BY aval.notaavaliacao DESC
                SQL;
            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":id" => $userId
            ]);

            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function selectContratosProfissional($idcontratante)
    {
        try {
            $sql = <<<SQL
                  SELECT contrt.idcontrato, idcontratante, json_agg(diacontrato) AS diascontrato, statcontrt.idstatus, timecriacaocontrato, timefinalizacaocontrato, descrespec, usr.iduser, nomeuser, imguser
                  FROM contrato AS contrt
                  INNER JOIN diacontrato AS diacontrt ON (contrt.idcontrato = diacontrt.idcontrato)
                  INNER JOIN statuscontrato AS statcontrt ON (contrt.idStatus = statcontrt.idStatus)
                  INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                  INNER JOIN usuario AS usr ON (contrt.idcontratante = usr.iduser)
                  WHERE (contrt.idcontratado = :idcontratante)
                  GROUP BY contrt.idcontrato, statcontrt.idstatus, descrespec, nomeuser, imguser, usr.iduser
              SQL;



            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":idcontratante" => $idcontratante
            ]);

            $result = $stmt->fetchAll();

            // converte json_agg() [String] para array associativa
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]["diascontrato"] = json_decode($result[$i]["diascontrato"]);
            }
            
            // ordena as datas do contrato
            for ($i = 0; $i < count($result); $i++) {
                sort($result[$i]["diascontrato"]);
            }

            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function selectContratosContratante($idcontratante)
    {
        try {
            $sql = <<<SQL
                    SELECT contrt.idcontrato, idcontratado, json_agg(diacontrato) AS diascontrato, statcontrt.idstatus, timecriacaocontrato, timefinalizacaocontrato, descrespec, usr.iduser, nomeuser, imguser
                    FROM contrato AS contrt
                    INNER JOIN diacontrato AS diacontrt ON (contrt.idcontrato = diacontrt.idcontrato)
                    INNER JOIN statuscontrato AS statcontrt ON (contrt.idStatus = statcontrt.idStatus)
                    INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                    INNER JOIN usuario AS usr ON (contrt.idcontratado = usr.iduser)
                    WHERE (contrt.idcontratante = :idcontratante)
                    GROUP BY contrt.idcontrato, statcontrt.idstatus, descrespec, nomeuser, imguser, usr.iduser
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":idcontratante" => $idcontratante
            ]);

            $result = $stmt->fetchAll();

            // converte json_agg() [String] para array associativa
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]["diascontrato"] = json_decode($result[$i]["diascontrato"]);
            }

            // ordena as datas do contrato
            for ($i = 0; $i < count($result); $i++) {
                sort($result[$i]["diascontrato"]);
            }

            return $result;
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
                    WHERE (notific.iddestinatario = :id) AND (isavaliado = FALSE);
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

    public function selectCalendario($idUser) {
        try {
            $sql = <<<SQL
                    SELECT contrt.idContrato, descrContrato, descrStatus, corCalendario, json_agg(diaContrato) AS diascontrato
                    FROM contrato AS contrt
                    INNER JOIN diacontrato as dias ON (contrt.idcontrato = dias.idcontrato)
                    INNER JOIN statusContrato as stat ON (contrt.idStatus = stat.idStatus)
                    WHERE (contrt.idcontratante = :id) OR (contrt.idcontratado = :id)
                    GROUP BY contrt.idContrato, descrContrato, corCalendario, descrStatus
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":id" => $idUser
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
    //!SECTION - SELECTS


    //SECTION - INSERTS
    // insere um usuário com as informações passadas por parâmetro
    public function insertBasicInfo($nome, $email, $cpf, $telefone, $senha)
    {
        try {
            // verifica se já existe um usuário cadastro com esse email
            $verifySQL = "SELECT iduser FROM usuario WHERE emailuser = :email";
            $verifyEmail = Database::prepare($verifySQL);
            $verifyEmail->execute([":email" => $email]);

            // se não existem usuários cadastrados com esse email, segue para insert
            if ($verifyEmail->rowCount() < 1) {
                // insert do novo usuário
                $insertSQL = "INSERT INTO usuario(nomeuser, emailuser, cpfuser, telefoneuser, senhauser) VALUES (:nome, :email, :cpf, :telefone, :senha)";
                $insertSTMT = Database::prepare($insertSQL);
                $insertSTMT->execute([
                    ":nome" => $nome,
                    ":email" => $email,
                    ":cpf" => $cpf,
                    ":telefone" => $telefone,
                    ":senha" => $senha
                ]);

                return ["dados" => true];
            } else {
                return ["erro" => "Email já cadastrado"];
            }
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function insertEspec($userId, $especId)
    {
        try {
            // se o usuário já está cadastrado com essa especialização
            $verifySQL = <<<SQL
                    SELECT usr.iduser 
                    FROM usuario AS usr
                    INNER JOIN userespec AS useres ON (usr.iduser = useres.iduser)
                    WHERE (usr.iduser = :userId) and (useres.idespec = :especId)
                SQL;
            $verifyEspec = Database::prepare($verifySQL);
            $verifyEspec->execute([
                ":userId" => $userId,
                ":especId" => $especId
            ]);

            // realiza o insert caso o usuário já não tenha cadastrado tal profissão
            if ($verifyEspec->rowCount() < 1) {
                // insert do registro de especialização
                $insertSQL = <<<SQL
                        INSERT INTO userespec(iduser, idespec) 
                        VALUES (:userId, :especId)
                    SQL;
                $insertSTMT = Database::prepare($insertSQL);
                $insertSTMT->execute([
                    ":userId" => $userId,
                    ":especId" => $especId
                ]);

                return ["dados" => true];
            } else {
                return ["erro" => "Especialização já cadastrada"];
            }
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }
    //!SECTION - INSERTS


    //SECTION - UPDATES
    // altera as informações de um usuário com id para os dados recebidos por parâmetro
    public function updateInfo($userId, $nome, $email, $imgBase64, $nascimento, $telefone, $bio)
    {
        try {
            // verifica se não existe nenhum email idêntico cadastrado (desconsiderando o email do próprio usuário)
            $verifySQL = "SELECT iduser FROM usuario WHERE (emailuser = :email) AND (iduser <> :id)";
            $verifySTMT = Database::prepare($verifySQL);
            $verifySTMT->execute([
                ":email" => $email,
                ":id" => $userId
            ]);

            if ($verifySTMT->rowCount() < 1) {
                // SQLs diferentes para não deixar a foto vazia no banco de dados
                if ($imgBase64 != "") {
                    $sql = <<<SQL
                        UPDATE usuario
                        SET nomeuser = :nome, emailuser = :email, imguser = :img, nascimentouser = :nascimento, telefoneuser = :telefone, biografiauser = :bio
                        WHERE iduser = :id
                        SQL;

                    $stmt = Database::prepare($sql);
                    $stmt->execute([
                        ":id" => $userId,  // INT
                        ":nome" => $nome,  // STRING
                        ":email" => $email,  // STRING
                        ":img" => $imgBase64,  // STRING
                        ":nascimento" => $nascimento,  // ?
                        ":telefone" => $telefone,  // STRING
                        ":bio" => $bio
                    ]);
                } else {
                    $sql = <<<SQL
                        UPDATE usuario
                        SET nomeuser = :nome, emailuser = :email, nascimentouser = :nascimento, telefoneuser = :telefone, biografiauser = :bio
                        WHERE iduser = :id
                        SQL;

                    $stmt = Database::prepare($sql);
                    $stmt->execute([
                        ":id" => $userId,  // INT
                        ":nome" => $nome,  // STRING
                        ":email" => $email,  // STRING
                        ":nascimento" => $nascimento,  // ?
                        ":telefone" => $telefone,  // STRING
                        ":bio" => $bio
                    ]);
                }


                return ["dados" => true];
            } else {
                return ["erro" => "Email já cadastrado"];
            }
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }


    public function updateSenha($userId, $senhaAtual, $senhaNova)
    {
        try {
            $verifySenhaSQL = "SELECT iduser FROM usuario WHERE (iduser = :id) AND (senhauser = :senhaAtual)";
            $verifySTMT = Database::prepare($verifySenhaSQL);
            $verifySTMT->execute([
                ":id" => $userId,
                ":senhaAtual" => $senhaAtual
            ]);

            if ($verifySTMT->rowCount() > 0) {
                $sql = "UPDATE usuario SET senhauser = :senhaNova WHERE iduser = :id";
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $userId,
                    ":senhaNova" => $senhaNova
                ]);

                return ["dados" => true];
            } else {
                return [
                    "erro" => "A senha atual digitada está incorreta"
                ];
            }
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }
    //!SECTION - UPDATES


    //SECTION - DELETES
    // deleta um usuário a partir do id passado por parâmetro
    public function deleteById($userId)
    {
        try {
            $sql = "DELETE FROM usuario WHERE iduser = :id";

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":id" => $userId
            ]);

            return ["dados" => true];
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function deleteEspecById($userId, $especId)
    {
        try {
            $sql = <<<SQL
                DELETE FROM userespec
                WHERE (iduser = :userId) and (idEspec = :especId)
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":userId" => $userId,
                ":especId" => $especId
            ]);

            if ($stmt->rowCount() > 0) {
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
    //!SECTION - DELETES
}
