<?php 
    require_once "Database.php";

    class Usuario extends Database {

        // retorna usuário com o id passado por parâmetro
        public function selectBasicInfoById($id) {
            try {
                $sql = <<<SQL
                    SELECT nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr 
                    FROM usuario
                    WHERE idusr = :id;
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);
                
                $result = $stmt->fetch();

                return $result;
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "action" => false ];
            }
        }


        public function selectPerfilPublicoById($id) {
            try {
                // tá feio :(
                $sql = <<<SQL
                        SELECT usrinfo.idusr, round(avg(notaavaliacao), 1) AS mediaavaliacao, nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr, numcontrato, especsusr
                        FROM (SELECT usr.idusr, nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr, count(*) AS numcontrato, json_agg(dscespec) AS especsusr
                                FROM usuario AS usr
                                INNER JOIN usrespec AS usres ON (usres.idusr = usr.idusr)
                                INNER JOIN especializacao AS espec ON (usres.idespec = espec.idespec)
                                WHERE usr.idusr = :id
                                GROUP BY usr.idusr, nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr
                        ) AS usrinfo
                        INNER JOIN usres
                        INNER JOIN contrato AS contrt ON (usrinfo.idusr = contrt.idcontratado)
                        INNER JOIN avaliacao AS aval ON (contrt.idcontrato = aval.idcontrato)
                        GROUP BY usrinfo.idusr, nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr, numcontrato, especsusr
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);
                
                $result = $stmt->fetch();

                if (isset($result["especsusr"])) {
                    $result["especsusr"] = json_decode($result["especsusr"]);
                }

                return $result;
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "action" => false ];
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
                
                return [ "action" => false ];
            }
        }
        

        public function selectEspecsById($id) {
            try {
                $sql = <<<SQL
                    SELECT dscespec, 
                SQL;

                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);

                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();
                
                return [ "action" => false ];
            }
        }


        public function selectAvalById($id, $filterNota = "DESC") {
            try {
                $sql = <<<SQL
                    SELECT avalusr.nomusr, avalusr.imgusr, avalusr.comentarioavaliacao, round(avg(avalusr.notaavaliacao), 1) AS mediaavaliacao
                    FROM (SELECT usr.idusr, usr.nomusr, imgusr, comentarioavaliacao, notaavaliacao
                        FROM avaliacao AS aval
                        INNER JOIN contrato AS contrt ON (aval.idcontrato = contrt.idcontrato)
                        INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                        INNER JOIN usuario AS usr ON (contrt.idcontratante = usr.idusr)
                        WHERE contrt.idcontratado = :id
                        ORDER BY aval.notaavaliacao DESC) AS avalusr
                    GROUP BY avalusr.idusr
                SQL;
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);

                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "action" => false ];
            }
        }


        // insere um usuário com as informações passadas por parâmetro
        public function insertBasicInfo($nome, $email, $senha) {
            try {
                // verifica se já existe um usuário cadastro com esse email
                $verifySQL = "SELECT idUsr FROM usuario WHERE emailUsr = :email";
                $verifyEmail = Database::prepare($verifySQL);
                $verifyEmail->execute([ ":email" => $email ]);

                // se não existem usuários cadastrados com esse email, segue para insert
                if ($verifyEmail->rowCount() < 1) {
                    // insert do novo usuário
                    $insertSQL = "INSERT INTO usuario(nomUsr, emailUsr, senhaUsr) VALUES (:nome, :email, :senha)";
                    $insertSTMT = Database::prepare($insertSQL);
                    $insertSTMT->execute([
                        ":nome" => $nome,
                        ":email" => $email,
                        ":senha" => $senha
                    ]);

                    return [ "action" => true ];
                } else {
                    return [ "erro" => "Email já cadastrado" ];
                }
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "action" => false ];
            }
        }


        // altera as informações de um usuário com id para os dados recebidos por parâmetro
        public function updateInfo($id, $nome, $email, $imgBase64, $nascimento, $telefone, $bio) {
            try {
                // verifica se não existe nenhum email idêntico cadastrado (desconsiderando o email do próprio usuário)
                $verifySQL = "SELECT idUsr FROM usuario WHERE (emailUsr = :email) AND (idUsr <> :id)";
                $verifySTMT = Database::prepare($verifySQL);
                $verifySTMT->execute([ 
                    ":email" => $email,
                    ":id" => $id
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
                            ":id" => $id,  // INT
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
                            ":id" => $id,  // INT
                            ":nome" => $nome,  // STRING
                            ":email" => $email,  // STRING
                            ":nascimento" => $nascimento,  // ?
                            ":telefone" => $telefone,  // STRING
                            ":bio" => $bio
                        ]);
                    }

    
                    return [ "action" => true ];
                } else {
                    return [ "erro" => "Email já cadastrado" ];
                }

            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "action" => false ];
            }
        }

        
        public function updateSenha($id, $senhaAtual, $senhaNova) {
            try {
                $verifySenhaSQL = "SELECT idusr FROM usuario WHERE (idusr = :id) AND (senhausr = :senhaAtual)";
                $verifySTMT = Database::prepare($verifySenhaSQL);
                $verifySTMT->execute([
                    ":id" => $id,
                    ":senhaAtual" => $senhaAtual
                ]);

                if ($verifySTMT->rowCount() > 0) {
                    $sql = "UPDATE usuario SET senhaUsr = :senhaNova WHERE idUsr = :id";
                    $stmt = Database::prepare($sql);
                    $stmt->execute([
                        ":id" => $id,
                        ":senhaNova" => $senhaNova
                    ]);
        
                    return [ "action" => true ];
                } else {
                    return [
                        "erro" => "A senha atual digitada está incorreta"
                    ];
                }
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "action" => false ];
            }
        }


        // deleta um usuário a partir do id passado por parâmetro
        public function deleteById($id) {
            try {
                $sql = "DELETE FROM usuario WHERE idUsr = :id";
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);
    
                return [ "action" => true ];
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "action" => false ];
            }
        }
    }
?>