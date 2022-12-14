<?php
require_once "Database.php";
require_once "NotificacaoContrato.php";

class Usuario extends Database
{
    use NotificacaoContrato;
    
    //seleciona todos os usuários da tabela usuário
    public function selectAllUsers() 
    {
        try {
            $sql = <<<SQL
                    SELECT usuario.*, bairro.descrbairro, cidade.descrcidade, estado.descrestado
                    FROM usuario 
                    INNER JOIN bairro ON (usuario.idbairro = bairro.idbairro)
                    INNER JOIN cidade ON (bairro.idcidade = cidade.idcidade)
                    INNER JOIN estado ON (cidade.idestado = estado.idestado)
                    ORDER BY iduser
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

    //seleciona todos os usuários da tabela usuário
    public function selectAllUsersPagination($limit, $offset) 
    {
        try {
            $sql = <<<SQL
                    SELECT usuario.*, bairro.descrbairro, cidade.descrcidade, estado.descrestado
                    FROM usuario 
                    INNER JOIN bairro ON (usuario.idbairro = bairro.idbairro)
                    INNER JOIN cidade ON (bairro.idcidade = cidade.idcidade)
                    INNER JOIN estado ON (cidade.idestado = estado.idestado)
                    ORDER BY iduser
                    OFFSET :offset
                    LIMIT :limit  
                SQL;
            
            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":limit" => $limit,
                ":offset" => $offset
            ]);

            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

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
            // general user info
            $sql = <<<SQL
                    SELECT userinfo.iduser, round(avg(notaavaliacao), 1) AS mediaavaliacao, nomeuser, emailuser, cpfuser, imguser, nascimentouser, telefoneuser, biografiauser, descrbairro, descrcidade, siglaestado
                    FROM (SELECT usr.iduser, nomeuser, emailuser, cpfuser, imguser, nascimentouser, telefoneuser, biografiauser, descrbairro, descrcidade, siglaestado
                            FROM usuario AS usr
                            INNER JOIN userespec AS useres ON (useres.iduser = usr.iduser)
                            INNER JOIN especializacao AS espec ON (useres.idespec = espec.idespec)
                            INNER JOIN bairro AS bair ON (usr.idbairro = bair.idbairro)
                            INNER JOIN cidade AS cid ON (bair.idcidade = cid.idcidade)
                            INNER JOIN estado AS es ON (cid.idestado = es.idestado)
                            WHERE usr.iduser = :id
                    ) AS userinfo
                    LEFT JOIN contrato AS contrt ON (userinfo.iduser = contrt.idcontratado)
                    LEFT JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    GROUP BY userinfo.iduser, nomeuser, emailuser, cpfuser, imguser, nascimentouser, telefoneuser, biografiauser, descrbairro, descrcidade, siglaestado
                SQL;
            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":id" => $userId
            ]);
            $generalInfo = $stmt->fetch();

            // especializacoes
            $especializacoes = $this->selectEspecsPerfPublicoById($userId);
            $descrEspecs = [];
            foreach ($especializacoes as $espec) {
                $descrEspecs[] = $espec["descrespec"];
            }
            $stringEspecs = ucfirst(implode(", ", $descrEspecs));

            // avaliacoes
            $avals = $this->selectAvaliacoesById($userId);
            $numAval = count($avals);
            
            [$bairro, $cidade, $estado] = [ucfirst($generalInfo["descrbairro"]), ucfirst($generalInfo["descrcidade"]), strtoupper($generalInfo["siglaestado"])];
            $localizacao = "{$bairro}, {$cidade} - {$estado}";

            $generatedData = [
                "especializacoes" => $especializacoes,
                "stringEspecs" => $stringEspecs,
                "avaliacoes" => $avals,
                "numAval" => $numAval,
                "localizacao" => $localizacao,
            ];
            $result = array_merge($generalInfo, $generatedData);

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
                    SELECT iduser, isadminuser, imguser, nomeuser
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
                    LEFT JOIN contrato AS contrt ON (espec.idespec = contrt.idespec AND contrt.idcontratado = :id)
                    LEFT JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE (usr.iduser = :id)
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


    public function selectAvaliacoesById($userId)
    {
        try {
            $sql = <<<SQL
                    SELECT usr.iduser, usr.nomeuser, espec.idespec, descrespec, imguser, comentarioavaliacao, dataavaliacao, round(notaavaliacao, 1) as notaavaliacao
                    FROM avaliacao AS aval
                    INNER JOIN contrato AS contrt ON (aval.idcontrato = contrt.idcontrato)
                    LEFT JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                    INNER JOIN usuario AS usr ON (contrt.idcontratante = usr.iduser)
                    WHERE (contrt.idcontratado = :id) AND (contrt.idstatus = 4)
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
                  SELECT contrt.idcontrato, idcontratante, contrt.descrcontrato, json_agg(diacontrato) AS diascontrato, statcontrt.idstatus, contrt.isavaliado, timecriacaocontrato, timefinalizacaocontrato, descrespec, usr.iduser, nomeuser, imguser
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
                    SELECT contrt.idcontrato, idcontratado, contrt.descrcontrato, json_agg(diacontrato) AS diascontrato, statcontrt.idstatus, contrt.isavaliado, timecriacaocontrato, timefinalizacaocontrato, descrespec, usr.iduser, nomeuser, imguser
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

    public function selectCalendario($idUser) {
        $conn = Database::getInstance();

        $conn->beginTransaction();
        try {
            $sqlContratado = <<<SQL
                    SELECT contrt.idContrato, usr.nomeuser, descrContrato, descrEspec, stat.idStatus, descrStatus, corCalendario, diacontrato
                    FROM contrato AS contrt
                    INNER JOIN diacontrato as dias ON (contrt.idcontrato = dias.idcontrato)
                    INNER JOIN statusContrato as stat ON (contrt.idStatus = stat.idStatus)
                    INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                    INNER JOIN usuario AS usr ON (contrt.idcontratante = usr.iduser)
                    WHERE (contrt.idcontratado = :id)
                SQL;

            $stmt = $conn->prepare($sqlContratado);
            $stmt->execute([
                ":id" => $idUser
            ]);

            $contratado = $stmt->fetchAll();

            $sqlContratante = <<<SQL
                SELECT contrt.idContrato, usr.nomeuser, descrContrato, descrEspec, descrStatus, corCalendario, diacontrato
                FROM contrato AS contrt
                INNER JOIN diacontrato as dias ON (contrt.idcontrato = dias.idcontrato)
                INNER JOIN statusContrato as stat ON (contrt.idStatus = stat.idStatus)
                INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                INNER JOIN usuario AS usr ON (contrt.idcontratado = usr.iduser)
                WHERE (contrt.idcontratante = :id)
            SQL;

            $stmt = $conn->prepare($sqlContratante);
            $stmt->execute([
                ":id" => $idUser
            ]);

            $contratante = $stmt->fetchAll();

            $conn->commit();
            return [$contratado, $contratante];
        } catch (PDOException $e) {
            $conn->rollback();
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function selectEstadoBySigla($siglaEstado) {
        try {
            $sql = <<<SQL
                    SELECT * 
                    FROM estado 
                    WHERE siglaestado = :sigla
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":sigla" => $siglaEstado
            ]);

            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function selectCidadeByNome($nomeCidade) {
        try {
            $sql = <<<SQL
                    SELECT * 
                    FROM cidade 
                    WHERE descrcidade = :nome
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":nome" => $nomeCidade
            ]);

            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function selectBairroByNome($nomeBairro) {
        try {
            $sql = <<<SQL
                    SELECT * 
                    FROM bairro 
                    WHERE descrbairro = :nome
                SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":nome" => $nomeBairro
            ]);

            $result = $stmt->fetch();
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
    public function insertBasicInfo($nome, $email, $cpf, $telefone, $senha, $bairro, $nascimento)
    {
        try {
            // verifica se já existe um usuário cadastro com esse email
            $verifySQL = "SELECT iduser FROM usuario WHERE emailuser = :email";
            $verifyEmail = Database::prepare($verifySQL);
            $verifyEmail->execute([":email" => $email]);

            // se não existem usuários cadastrados com esse email, segue para insert
            if ($verifyEmail->rowCount() < 1) {
                // insert do novo usuário
                $insertSQL = "INSERT INTO usuario(nomeuser, emailuser, cpfuser, telefoneuser, senhauser, idbairro, nascimentouser) VALUES (:nome, :email, :cpf, :telefone, :senha, :bairro, :nascimento)";
                $insertSTMT = Database::prepare($insertSQL);
                $insertSTMT->execute([
                    ":nome" => $nome,
                    ":email" => $email,
                    ":cpf" => $cpf,
                    ":telefone" => $telefone,
                    ":senha" => $senha,
                    ":bairro" => $bairro,
                    ":nascimento" => $nascimento
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

    public function insertCidade($nomeCidade, $idEstado) {
        try {
            $insertSQL = <<<SQL
                        INSERT INTO cidade (descrCidade, idEstado) 
                        VALUES (:nomeCidade, :idEstado)
                    SQL;
                $insertSTMT = Database::prepare($insertSQL);
                $insertSTMT->execute([
                    ":nomeCidade" => $nomeCidade,
                    ":idEstado" => $idEstado
                ]);

                return ["dados" => true];
        }
        catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }

    public function insertBairro($nomeBairro, $idCidade) {
        try {
            $insertSQL = <<<SQL
                        INSERT INTO bairro (descrBairro, idCidade) 
                        VALUES (:nomeBairro, :idCidade)
                    SQL;
                $insertSTMT = Database::prepare($insertSQL);
                $insertSTMT->execute([
                    ":nomeBairro" => $nomeBairro,
                    ":idCidade" => $idCidade
                ]);

                return ["dados" => true];
        }
        catch (PDOException $e) {
            echo json_encode(["resposta" => "Query SQL Falhou: {$e->getMessage()}"]);
            exit();

            return ["dados" => false];
        }
    }


    //!SECTION - INSERTS


    //SECTION - UPDATES
    // altera as informações de um usuário com id para os dados recebidos por parâmetro
    public function updateInfo($userId, $nome, $email, $imgPath, $nascimento, $telefone, $bio)
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
                if ($imgPath != null) {
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
                        ":img" => $imgPath,  // STRING
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
