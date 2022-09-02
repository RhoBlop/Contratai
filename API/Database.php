<?php 
    $db = new Database();
    $result = $db->updateUserInfo(5, "Thiago N.", "thiago.neves@gmail.com", "batata@123", "11111111111", "thiago.png", "2004-03-28", "27912345678");
    echo $result;

    class Database {
        // credenciais banco de dados
        private $dsn = "pgsql:host=fanny.db.elephantsql.com;port=5432;dbname=fiutwocm";
        private $username = "fiutwocm";
        private $password = "CaP72wiKK6956Kts5JGBHg8VyxOSimyS";
        private $conn;

        public function __construct() {
            // tenta realizar a conexão com o banco de dados
            try {
                $this->conn = new PDO($this->dsn, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                
                // faz com que o PDO lance uma PDOException em qualquer problema que acontecer (teoricamente) 
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: {$e->getMessage()}";
                exit();
            }
        }

        // retorna usuário com o id passado por parâmetro
        public function getUser($id) {
            try {
                $sql = "SELECT * FROM usuario WHERE idusr = :id";
    
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);
                
                $result = $stmt->fetch();
                return $result;
            } catch (PDOException $e) {
                echo "SQL Query Failed: {$e->getMessage()}";

                return false;
            }
            
        }

        // insere um usuário com as informações passadas por parâmetro
        public function createBasicUser($nome, $email, $senha) {
            try {
                $sql = "INSERT INTO usuario(nomUsr, dscEmailUsr, dscSenhaUsr) VALUES (:nome, :email, :senha)";
    
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ":nome" => $nome,
                    ":email" => $email,
                    ":senha" => $senha
                ]);

                return true;
            } catch (PDOException $e) {
                echo "SQL Query Failed: {$e->getMessage()}";

                return false;
            }
        }

        // altera as informações de um usuário com id para os dados recebidos por parâmetro
        public function updateUserInfo($id, $nome, $email, $senha, $cpf, $imgBase64, $datNascimento, $telefone) {
            try {
                $sql = <<<SQL
                UPDATE usuario
                SET nomusr = :nome, dscEmailUsr = :email, dscSenhaUsr = :senha, numCPFusr = :cpf, dscFotoUsr = :img, datNascimentoUsr = :nascimento, numTelefoneUsr = :telefone
                WHERE idUsr = :id
                SQL;
    
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ":id" => $id,  // INT
                    ":nome" => $nome,  // STRING
                    ":email" => $email,  // STRING
                    ":senha" => $senha,  // STRING
                    ":cpf" => $cpf,  // STRING
                    ":img" => $imgBase64,  // STRING
                    ":nascimento" => $datNascimento,  // ?
                    ":telefone" => $telefone,  // STRING
                ]);

                return true;
            } catch(PDOException $e) {
                echo "SQL Query Failed: {$e->getMessage()}";

                return false;
            }
        }

        // deleta um usuário a partir do id passado por parâmetro
        public function deleteUser($id) {
            try {
                $sql = "DELETE FROM usuario WHERE idusr=:id";
    
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ":id" => $id
                ]);
    
                return true;
            } catch (PDOException $e) {
                echo "SQL Query Failed: {$e->getMessage()}";

                return false;
            }

        }

        public function getTopCategorias() {

        }
    }
?>