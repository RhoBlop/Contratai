<?php
require_once "Database.php";

class Teste extends Database {
    private $ids = [1, 2, 3, 4, 5];

    public function testMultipleSql() {
        foreach($this->ids as $id) {
            $sql = <<<SQL
                select * from usuario where iduser = :iduser
            SQL;

            $stmt = Database::prepare($sql);
            $stmt->execute([
                ":iduser" => $id
            ]);

            $stmt->fetch();
        }
    }

    public function testUniqueSql() {
        $sql = <<<SQL
            select * from usuario where iduser BETWEEN 0 and 6
        SQL;

        $stmt = Database::prepare($sql);
        $stmt->execute([
        ]);

        $stmt->fetch();
    }
}

// $contrt1 = new Teste();
// $contrt1->testUniqueSql();

$contrt2 = new Teste();
$contrt2->testMultipleSql();

?>