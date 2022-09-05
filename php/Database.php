<?php
    class Database {
        // credenciais banco de dados
        private $dsn = "pgsql:host=fanny.db.elephantsql.com;port=5432;dbname=fiutwocm";
        private $username = "fiutwocm";
        private $password = "CaP72wiKK6956Kts5JGBHg8VyxOSimyS";
        private $conn;

        public function __construct() {
            // tenta realizar a conexão com o banco de dados
            try {
                $this->conn = new PDO($this->dsn, $this->username, $this->password, array(PDO::ATTR_PERSISTENT => TRUE));
                
                // faz com que o PDO lance uma PDOException em qualquer problema que acontecer (teoricamente) 
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // echo "Conexão criada com sucesso \n";
            } catch (PDOException $e) {
                echo "Conexão falhou: {$e->getMessage()}";
                exit();
            }
        }

        // retorna usuário com o id passado por parâmetro
        public function selectUserById($id) {
            try {
                $sql = "SELECT * FROM usuario WHERE idusr = :id";
    
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);
                
                $result = $stmt->fetch();
                return $result;
            } catch (PDOException $e) {
                echo "Query SQL Falhou: {$e->getMessage()}";

                return false;
            }
            
        }

        public function selectUserLogin($email, $senha) {
            try {
                $sql = "SELECT idUsr FROM usuario WHERE (dscEmailUsr = :email) AND (dscSenhaUsr = :senha)";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ":email" => $email,
                    ":senha" => $senha
                ]);

                $result = $stmt->fetch();
                if ($result) {
                    // retorna ID do usuário
                    return $result['idusr'];
                } else {
                    return "credenciais invalidas";
                }
            } catch (PDOException $e) {
                echo "Query SQL Falhou: {$e->getMessage()}";

                return false;
            }
        }

        // insere um usuário com as informações passadas por parâmetro
        public function insertBasicUser($nome, $email, $senha) {
            try {
                // verifica se já existe um usuário cadastro com esse email
                $validEmail = $this->checkIfValidEmail($email);

                // se não existem usuários cadastrados com esse email, segue para insert
                if ($validEmail) {
                    // insert do novo usuário
                    $insertSQL = "INSERT INTO usuario(nomUsr, dscEmailUsr, dscSenhaUsr) VALUES (:nome, :email, :senha)";
                    $insertSTMT = $this->conn->prepare($insertSQL);
                    $insertSTMT->execute([
                        ":nome" => $nome,
                        ":email" => $email,
                        ":senha" => $senha
                    ]);

                    return true;
                } else {
                    return "ja existe um usuario cadastrado com esse email";
                }
            } catch (PDOException $e) {
                echo "Query SQL Falhou: {$e->getMessage()}";

                return false;
            }
        }

        // altera as informações de um usuário com id para os dados recebidos por parâmetro
        public function updateUserInfo($id, $nome, $email, $cpf, $imgBase64, $nascimento, $telefone, $senha=null) {
            try {
                $verifySQL = "SELECT idUsr FROM usuario WHERE (dscEmailUsr = :email) AND (idUsr <> :id)";
                $verifySTMT = $this->conn->prepare($verifySQL);
                $verifySTMT->execute([ 
                    ":email" => $email,
                    ":id" => $id
                ]);

                if ($verifySTMT->rowCount() < 1) {
                    $updateTable = [
                        "nomUsr" => $nome,
                        "dscEmailUsr" => $email,
                        "dscSenhaUsr" => $senha,
                        "numCPFUsr" => $cpf,
                        "dscFotoUsr" => $imgBase64,
                        "datNascimentoUsr" => $nascimento,
                        "numTelefoneUsr" => $telefone
                    ];

                    // check if empty for every value on associative array


                    

                    $set = "SET nomusr = :nome, dscEmailUsr = :email, numCPFusr = :cpf, dscFotoUsr = :img, datNascimentoUsr = :nascimento, numTelefoneUsr = :telefone"; 
    
                    if ($senha) {
                        $set = "{$set}, dscsenhausr = :senha";
                    }
    
                    $sql = "UPDATE {$set} WHERE idusr = :id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([
                        ":id" => $id,  // INT
                        ":nome" => $nome,  // STRING
                        ":email" => $email,  // STRING
                        ":senha" => $senha,  // STRING
                        ":cpf" => $cpf,  // STRING
                        ":img" => $imgBase64,  // STRING
                        ":nascimento" => $nascimento,  // ?
                        ":telefone" => $telefone,  // STRING
                    ]);
    
                    return true;
                } else {
                    return "ja existe um usuario cadastrado com esse email";
                }

            } catch(PDOException $e) {
                echo "Query SQL Falhou: {$e->getMessage()}";

                return false;
            }
        }

        // deleta um usuário a partir do id passado por parâmetro
        public function deleteUser($id) {
            try {
                $sql = "DELETE FROM usuario WHERE idusr = :id";
    
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);
    
                return true;
            } catch (PDOException $e) {
                echo "Query SQL Falhou: {$e->getMessage()}";

                return false;
            }

        }

        public function getTopCategorias() {

        }

        public function checkIfValidEmail($email) {
            $verifySQL = "SELECT idUsr FROM usuario WHERE dscEmailUsr = :email";
            $verifySTMT = $this->conn->prepare($verifySQL);
            $verifySTMT->execute([ ":email" => $email ]);

            if ($verifySTMT->rowCount() < 1) {
                return true;
            } else {
                return false;
            }
        }
    }
?>