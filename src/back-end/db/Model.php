<?php
require_once("Database.php");

class Model {
    protected $conn;
    protected $table;

    public function __construct(){
        $this->conn = Database::getInstance()->getConnection();
    }

    public function find(...$args) {
        if (count($args) % 2 != 0) throw new InvalidArgumentException("Value, Column pairs are required for the find method.");
    
        $conditions = [];
        $values = [];
        
        for ($i = 0; $i < count($args); $i += 2) {
            $column = $args[$i + 1]; 
            $value = $args[$i];
    
            $conditions[] = "$column = :param$i";
            $values[":param$i"] = $value;
        }
    
        $whereClause = implode(" AND ", $conditions);
        $query = "SELECT * FROM $this->table WHERE $whereClause";
    
        $stmt = $this->conn->prepare($query);
    
        foreach ($values as $param => $val) {
            $stmt->bindValue($param, $val);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>