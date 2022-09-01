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
                $this->conn = new PDO($this->dsn, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (PDOException $e) {
                echo ($e->getMessage());
                exit();
            }
        }

        public function selectUser($id) {
            $sql = "SELECT * FROM usuario WHERE idusr = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ":id" => $id
            ]);
            
            $result = $stmt->fetch();
            return $result;
        }

        // insere um usuário com as informações passadas por parâmetro
        public function insertBasicUser($nome, $email, $senha) {
            $sql = "INSERT INTO usuario(nomUsr, dscEmailUsr, dscSenhaUsr) VALUES (:nome, :email, :senha)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ":nome" => $nome,
                ":email" => $email,
                ":senha" => $senha
            ]);

            // retorna 1 se o insert deu certo
            $result = $stmt->rowCount();
            return $result;
        }

        public function updateUserInfo($id, $nome, $email, $senha, $cpf, $imgBase64, $) {
            $sql = <<<SQL
            UPDATE usuario
            SET nomusr = :nome,
                
        }

        // deleta um usuário a partir do id passado por parâmetro
        public function deleteUser($id) {
            $sql = "DELETE FROM usuario WHERE idusr=:id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ":id" => $id
            ]);

            $result = $stmt->rowCount();
            return $result;
        }
    }

    $db = new Database();
    $result = $db->insertBasicUser("Thiago", "thiago.neves@gmail.com", "batata@123");
    echo $result;
?>