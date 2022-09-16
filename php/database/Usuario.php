<?php 
    require_once "./Database.php";

    class Usuario {

        // retorna usuário com o id passado por parâmetro
        public function getById($id) {
            try {
                $sql = "SELECT nomusr, emailusr, senhausr, cpfusr, imgusr, nascimentousr, telefoneusr, biografiausr FROM usuario WHERE idusr = :id";
    
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);
                
                $result = $stmt->fetch();
                return [ "dados" => $result ];
            } catch (PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);

                return [ "action" => false ];
            }
        }


        // retorna usuário para login, ou seja, a partir de um email e uma senha
        public function getLogin($email, $senha) {
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
    
                    return [ "action" => true ];
                } else {
                    return [ "erro" => "Email já cadastrado" ];
                }

            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);

                return [ "action" => false ];
            }
        }

        
        public function updateSenha($id, $senha) {
            try {
                $sql = "UPDATE usuario SET senhaUsr = :senha WHERE idUsr = :id";
                $stmt = Database::prepare($sql);
                $stmt->execute([
                    ":id" => $id,
                    ":senha" => $senha
                ]);
    
                return [ "action" => true ];
            } catch(PDOException $e) {
                echo json_encode([ "resposta" => "Query SQL Falhou: {$e->getMessage()}" ]);

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

                return [ "action" => false ];
            }
        }
    }
?>