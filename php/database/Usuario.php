<?php 
    require_once "Database.php";

    class Usuario extends Database {

        // retorna usuário com o id passado por parâmetro
        public function selectBasicInfoById($id) {
            try {
                $sql = "SELECT nomusr, emailusr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr FROM usuario WHERE idusr = :id";
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);
                
                $result = $stmt->fetch();

                return [ "dados" => $result ];
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);
                exit();

                return [ "action" => false ];
            }
        }


        public function selectAvalById($id) {
            try {
                $sql = <<<SQL
                    SELECT usr.nomusr, imgusr, descavaliacao, notaavaliacao, datavaliacao
                    FROM avaliacao AS aval
                    INNER JOIN contrato AS contrt ON (aval.idcontrato = contrt.idcontrato)
                    INNER JOIN especializacao AS espec ON (contrt.idespec = espec.idespec)
                    INNER JOIN usuario AS usr ON (contrt
                    idcontratante = usr.idusr)
                    WHERE contrt.idcontratado = :idusr
                    ORDER BY aval.notaavaliacao : filterNota
                SQL;
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