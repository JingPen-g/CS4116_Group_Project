<?php
require_once("Database.php");

class Model {
    protected $conn;
    protected $table;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }


    //Expected criteria of the form ['ColName1' => val1, 'ColName2' => val2]
    //Expected cols of the form ['ColName1', 'ColName2']
    protected function find(array $criteria = [], array $cols = []) {
        if (empty($criteria)) {
            return $this->fetchAll();
        }

        $conditions = [];
        $values = [];
        $types = "";

        foreach ($criteria as $column => $value) {
            $conditions[] = "$column = ?";
            $values[] = &$value;

            $types .= $this->decideType($value);
        }

        $whereClause = implode(" AND ", $conditions);

        $query = "";

        if(empty($cols)) $query = "SELECT * FROM $this->table WHERE $whereClause";
        else {
            $selectCols = implode(", ", $cols);
            $query = "SELECT $selectCols FROM $this->table WHERE $whereClause";
        }

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters
        if (!empty($values)) {
            $refs = array_merge([$stmt, $types], $values);
            call_user_func_array('mysqli_stmt_bind_param', $refs);
        }

        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $rows = $this->fetchDBResults($result);
        $stmt->close();

        return $rows;
    }

    //Expected values of type ['ColName1' => val1, 'ColName2' => val2]
    protected function insert(array $values = []){
        if (empty($values)){
            throw new Exception("Values not found.");
        }

        $cols = [];
        $values = [];
        $types = "";

        foreach($values as $column => $value){
            $cols[] = $column;
            $values[] = &$value;

            $types .= $this->decideType($value);
        }
        
        $columnList = implode(", ", $cols);
        $valueList = implode(", ", array_fill(0, count($values), "?"));

        $query = "INSERT INTO $this->table ($columnList) VALUES ($valueList)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters
        if (!empty($values)) {
            $refs = array_merge([$stmt, $types], $values);
            call_user_func_array('mysqli_stmt_bind_param', $refs);
        }

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Failed to Insert: " . $stmt->error);
        }

        $stmt->close();
    }

    //THIS NEXT
    protected function update(){}
    
    protected function delete(){}

    protected function count() {
        $query = "SELECT COUNT(*) AS count FROM $this->table";

        $result = $this->conn->query($query);

        if (!$result) {
            throw new Exception("Query failed: " . $this->conn->error);
        }

        $rows = $this->fetchDBResults($result);

        return $rows;

    }

    private function fetchAll() {
        $query = "SELECT * FROM $this->table";
        $result = $this->conn->query($query);

        if (!$result) {
            throw new Exception("Query failed: " . $this->conn->error);
        }

        $rows = $this->fetchDBResults($result);

        return $rows;
    }

    private function fetchDBResults($result){
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }  

    //This 100% will need to be extended.
    //If you encounter a bug it most likely is because the type isnt present here
    private function decideType($value) {
        if (is_int($value)) {
            return'i'; 
        } elseif (is_double($value)) {
            return 'd'; 
        } else {
            return 's';
        }
    }
}
?>