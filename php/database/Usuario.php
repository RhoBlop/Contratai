<?php 
    require_once "Database.php";

    class Usuario extends Database {

        /* ================================
                       SELECTS
           ================================ */

        // retorna usuário com o id passado por parâmetro
        public function selectBasicInfoById($usrId) {
            try {
                $sql = <<<SQL
                    SELECT nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr 
                    FROM usuario
                    WHERE idusr = :id;
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $usrId
                ]);
                
                $result = $stmt->fetch();

                return $result;
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "dados" => false ];
            }
        }


        public function selectPerfilPublicoById($usrId) {
            try {
                // tá feio :(
                $sql = <<<SQL
                        SELECT usrinfo.idusr, round(avg(notaavaliacao), 1) AS mediaavaliacao, nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr, numcontrato
                        FROM (SELECT usr.idusr, nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr, count(*) AS numcontrato
                                FROM usuario AS usr
                                INNER JOIN usrespec AS usres ON (usres.idusr = usr.idusr)
                                INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                                WHERE usr.idusr = :id
                                GROUP BY usr.idusr, nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr
                        ) AS usrinfo
                        LEFT JOIN contrato AS contrt ON (usrinfo.idusr = contrt.idcontratado)
                        LEFT JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                        GROUP BY usrinfo.idusr, nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr, numcontrato
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $usrId
                ]);
                
                $result = $stmt->fetch();

                return $result;
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "dados" => false ];
            }
        }
        

        // retorna usuário para login, ou seja, a partir de um email e uma senha
        public function selectLogin($email, $senha) {
            try {
                $sql = "SELECT idusr FROM usuario WHERE (emailUsr = :email) AND (senhaUsr = :senha)";
                
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":email" => $email,
                    ":senha" => $senha
                ]);
                
                $result = $stmt->fetch();
                if ($result) {
                    // retorna ID do usuário
                    return [ "dados" => $result ];
                } else {
                    return [ "erro" => "Email ou senha inválidos" ];
                }
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }


        public function selectProfissoessById($usrId) {
            try {
                $sql = <<<SQL
                    SELECT usres.idusrespec, dscprof, dscespec
                    FROM usuario AS usr
                    INNER JOIN usrespec AS usres ON (usr.idusr = usres.idusr)
                    INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                    INNER JOIN profissao AS prof ON (espec.idprof = prof.idprof)
                    WHERE usr.idusr = :id
                    ORDER BY dscprof ASC
                SQL;

                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $usrId
                ]);

                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }
        

        public function selectEspecsPerfPublicoById($usrId) {
            try {
                $sql = <<<SQL
                    SELECT espec.idespec, dscespec, round(avg(notaavaliacao), 1) AS mediaavaliacao
                    FROM usuario AS usr
                    INNER JOIN usrespec AS usres ON (usr.idusr = usres.idusr)
                    INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                    LEFT JOIN contrato AS contrt ON (espec.idespec = contrt.idespec)
                    LEFT JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                    WHERE usr.idusr = :id
                    GROUP BY espec.idespec, dscespec
                    ORDER BY mediaavaliacao DESC NULLS LAST
                SQL;

                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $usrId
                ]);

                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "dados" => false ];
            }
        }


        public function selectAvaliacoesById($usrId, $filterNota = "DESC") {
            try {
                $sql = <<<SQL
                    SELECT usr.idusr, usr.nomusr, espec.idespec, dscespec, imgusr, comentarioavaliacao, round(notaavaliacao, 1) as notaavaliacao
                    FROM avaliacao AS aval
                    INNER JOIN contrato AS contrt ON (aval.idcontrato = contrt.idcontrato)
                    INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                    INNER JOIN usuario AS usr ON (contrt.idcontratante = usr.idusr)
                    WHERE contrt.idcontratado = :id
                    ORDER BY aval.notaavaliacao DESC
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $usrId
                ]);

                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "dados" => false ];
            }
        }
        /* ================================
                       /SELECTS
           ================================ */


        /* ================================
                       INSERTS
           ================================ */

        // insere um usuário com as informações passadas por parâmetro
        public function insertBasicInfo($nome, $email, $cpf, $telefone, $senha) {
            try {
                // verifica se já existe um usuário cadastro com esse email
                $verifySQL = "SELECT idUsr FROM usuario WHERE emailUsr = :email";
                $verifyEmail = Database::prepare($verifySQL);
                $verifyEmail->execute([ ":email" => $email ]);

                // se não existem usuários cadastrados com esse email, segue para insert
                if ($verifyEmail->rowCount() < 1) {
                    // insert do novo usuário
                    $insertSQL = "INSERT INTO usuario(nomUsr, emailUsr, cpfUsr, telefoneUsr, senhaUsr) VALUES (:nome, :email, :cpf, :telefone, :senha)";
                    $insertSTMT = Database::prepare($insertSQL);
                    $insertSTMT->execute([
                        ":nome" => $nome,
                        ":email" => $email,
                        ":cpf" => $cpf,
                        ":telefone" => $telefone,
                        ":senha" => $senha
                    ]);

                    return [ "dados" => true ];
                } else {
                    return [ "erro" => "Email já cadastrado" ];
                }
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "dados" => false ];
            }
        }

        public function insertEspec($usrId, $especId) {
            try {
                // se o usuário já está cadastrado com essa especialização
                $verifySQL = <<<SQL
                    SELECT idUsr 
                    FROM usuario AS usr
                    INNER JOIN usrespec AS usres ON (usr.idusr = usres.idusr)
                    WHERE (usr.idusr = :usrId) and (usres.idespec = :especId)
                SQL;
                $verifyEspec = Database::prepare($verifySQL);
                $verifyEspec->execute([ 
                    ":usrId" => $usrId,
                    ":especId" => $especId
                ]);

                // realiza o insert caso o usuário já não tenha cadastrado tal profissão
                if ($verifyEspec->rowCount() < 1) {
                    // insert do registro de especialização
                    $insertSQL = <<<SQL
                        INSERT INTO usrespec(idusr, idespec) 
                        VALUES (:usrId, :especId)
                    SQL;
                    $insertSTMT = Database::prepare($insertSQL);
                    $insertSTMT->execute([
                        ":usrId" => $usrId,
                        ":especId" => $especId
                    ]);

                    return [ "dados" => true ];
                } else {
                    return [ "erro" => "Especialização já cadastrada" ];
                }
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "dados" => false ];
            }
        }
        /* ================================
                       /INSERTS
           ================================ */


        /* ================================
                       UPDATES
           ================================ */

        // altera as informações de um usuário com id para os dados recebidos por parâmetro
        public function updateInfo($usrId, $nome, $email, $imgBase64, $nascimento, $telefone, $bio) {
            try {
                // verifica se não existe nenhum email idêntico cadastrado (desconsiderando o email do próprio usuário)
                $verifySQL = "SELECT idUsr FROM usuario WHERE (emailUsr = :email) AND (idUsr <> :id)";
                $verifySTMT = Database::prepare($verifySQL);
                $verifySTMT->execute([ 
                    ":email" => $email,
                    ":id" => $usrId
                ]);

                if ($verifySTMT->rowCount() < 1) {
                    // SQLs diferentes para não deixar a foto vazia no banco de dados
                    if ($imgBase64 != "") {
                        $sql = <<<SQL
                        UPDATE usuario
                        SET nomusr = :nome, emailUsr = :email, imgUsr = :img, nascimentoUsr = :nascimento, telefoneUsr = :telefone, biografiaUsr = :bio
                        WHERE idusr = :id
                        SQL;
    
                        $stmt = Database::prepare($sql);
                        $stmt->execute([
                            ":id" => $usrId,  // INT
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
                        SET nomusr = :nome, emailUsr = :email, nascimentoUsr = :nascimento, telefoneUsr = :telefone, biografiaUsr = :bio
                        WHERE idusr = :id
                        SQL;
    
                        $stmt = Database::prepare($sql);
                        $stmt->execute([
                            ":id" => $usrId,  // INT
                            ":nome" => $nome,  // STRING
                            ":email" => $email,  // STRING
                            ":nascimento" => $nascimento,  // ?
                            ":telefone" => $telefone,  // STRING
                            ":bio" => $bio
                        ]);
                    }

    
                    return [ "dados" => true ];
                } else {
                    return [ "erro" => "Email já cadastrado" ];
                }

            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "dados" => false ];
            }
        }

        
        public function updateSenha($usrId, $senhaAtual, $senhaNova) {
            try {
                $verifySenhaSQL = "SELECT idusr FROM usuario WHERE (idusr = :id) AND (senhausr = :senhaAtual)";
                $verifySTMT = Database::prepare($verifySenhaSQL);
                $verifySTMT->execute([
                    ":id" => $usrId,
                    ":senhaAtual" => $senhaAtual
                ]);

                if ($verifySTMT->rowCount() > 0) {
                    $sql = "UPDATE usuario SET senhaUsr = :senhaNova WHERE idUsr = :id";
                    $stmt = Database::prepare($sql);
                    $stmt->execute([
                        ":id" => $usrId,
                        ":senhaNova" => $senhaNova
                    ]);
        
                    return [ "dados" => true ];
                } else {
                    return [
                        "erro" => "A senha atual digitada está incorreta"
                    ];
                }
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "dados" => false ];
            }
        }
        /* ================================
                       /UPDATES
           ================================ */


        /* ================================
                       DELETES
           ================================ */

        // deleta um usuário a partir do id passado por parâmetro
        public function deleteById($usrId) {
            try {
                $sql = "DELETE FROM usuario WHERE idUsr = :id";
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $usrId
                ]);
    
                return [ "dados" => true ];
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "dados" => false ];
            }
        }

        public function deleteEspecById($usrId, $especId) {

        }
    }
?>