<?php
    require_once "./Database.php";

    // essa classe define alguns métodos padrões para as classes herdeiras
    abstract class CRUD extends Database {
        protected $table;
        protected $idField;

        protected function insert($arr) {
            // array associativa com par chave-valor, onde: chave = nome do campo no BD; e valor = valor inserido
            $fields = implode(", ", array_keys($arr));
            $values = implode(", ", array_values($arr));
            $sql = "INSERT INTO {$this->table}({$fields}) VALUES {$values}";

            $stmt = Database::prepare($sql);

        
        }

        protected function find($id) {
            $sql = "SELECT * FROM $this->table WHERE $this->idField = :id";
            $stmt = Database::prepare($sql);
        }
        
    }
?>