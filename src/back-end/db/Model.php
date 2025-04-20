<?php
require_once("Database.php");

class Model {
    protected $conn;
    protected $table;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    /*
        Expected criteria of the form ['ColName1' => val1, 'ColName2' => val2]
        Expected cols of the form ['ColName1', 'ColName2']
    */
    protected function find(
        array $criteria = [], 
        array $cols = [], 
        array $customValues = [],
        string $customWhere = "",
        string $customExtra = ""
        ) {

        if (empty($criteria) && empty($customWhere)) {
            return $this->fetchAll();
        }

        $conditions = [];
        $values = [];
        $types = "";

        foreach ($criteria as $column => $value) {
            $conditions[] = "$column = ?";
            $values[] = &$criteria[$column];

            $types .= $this->decideType($value);
        }

        if(empty($customWhere))
            $whereClause = implode(" AND ", $conditions);
        else{
            $values = &$customValues;

            foreach ($values as $value) {
                $types .= $this->decideType($value);
            }

            $whereClause = $customWhere;
        }

        $query = "";

        if(empty($cols)) $query = "SELECT * FROM $this->table WHERE $whereClause";
        else {
            $selectCols = implode(", ", $cols);
            $query = "SELECT $selectCols FROM $this->table WHERE $whereClause";
        }

        $query .= $customExtra;
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
            throw new Exception("Execute failed: " . $query);
        }

        $rows = $this->fetchDBResults($result);
        $stmt->close();

        return $rows;
    }

    //Expected values of type ['ColName1' => val1, 'ColName2' => val2]
    protected function insert(array $data = []){
        if (empty($data)){
            throw new Exception("Values not found.");
        }
        $cols = [];
        $values = [];
        $types = "";

        foreach($data as $column => $value){
            $cols[] = $column;
            $values[] = &$data[$column];
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


        if (!$stmt->execute()) {
            // If insertion fails, return false
            return false;
        } 
        
        // Close the statement
        $stmt->close();
        
        // Return true if insertion was successful
        return true;
    }

    protected function update(array $conditions = [], array $data = []){
        if(empty($data)){
            throw new Exception("Values not found.");
        }

        $conditions_cols = [];
        $conditions_values = [];
        $conditions_types = "";

        foreach($conditions as $column => $value){
            $conditions_cols[] = "$column = ?";
            $conditions_values[] = &$conditions[$column];
            $conditions_types .= $this->decideType($value);
        }

        $data_cols = [];
        $data_values = [];
        $data_types = "";

        foreach($data as $column => $value){
            $data_cols[] = "$column = ?";
            $data_values[] = &$data[$column];
            $data_types .= $this->decideType($value);
        }

        // Combine conditions and data values since both need to be bound
        $values = array_merge($data_values, $conditions_values);
        $types = $data_types . $conditions_types;

        $conditionList = implode(" AND ", $conditions_cols);
        $dataList = implode(", ", $data_cols);

        $query = "";
        if(empty($conditions)){
            $query = "UPDATE $this->table SET $dataList";
        } else {
            $query = "UPDATE $this->table SET $dataList WHERE $conditionList";
        }

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        if (!empty($values)) {
            $refs = array_merge([$stmt, $types], $values);
            call_user_func_array('mysqli_stmt_bind_param', $refs);
        }

        if (!$stmt->execute()) {
            throw new Exception("Failed to Insert: " . $stmt->error . "\nAttempted query: " . $query);
        }

        $stmt->close();

        return true;
    }
    
    //The criteria here expects the same structure as past criteria so
    // ['ColName1' => va1, 'ColName2' => val2, ...]
    protected function delete(array $criteria){
        if (empty($criteria)) {
            throw new Exception("Criteria cannot be empty.");
        }

        $conditions = [];
        $values = [];
        $types = "";

        foreach ($criteria as $column => $value) {
            $conditions[] = "$column = ?";
            $values[] = &$criteria[$column];

            $types .= $this->decideType($value);
        }

        $whereClause = implode(" AND ", $conditions);

        $query = "DELETE FROM $this->table WHERE $whereClause";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters
        if (!empty($values)) {
            $refs = array_merge([$stmt, $types], $values);
            call_user_func_array('mysqli_stmt_bind_param', $refs);
        }

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        return true;
    }

    protected function count() {
        $query = "SELECT COUNT(*) AS count FROM $this->table";

        $result = $this->conn->query($query);

        if (!$result) {
            throw new Exception("Query failed: " . $this->conn->error);
        }

        $rows = $this->fetchDBResults($result);

        return $rows;

    }

    protected function fetchAll() {
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
            return 'i'; // Integer
        } elseif (is_float($value)) {
            return 'd'; // Double
        } elseif ($value instanceof DateTime) {
            return 's'; // DateTime objects are converted to strings (e.g., 'Y-m-d H:i:s')
        } elseif (is_array($value) || is_object($value)) {
            return 's'; // JSON-encoded arrays/objects are treated as strings
        } elseif ($value === null) {
            return 's'; // Null values are treated as strings (bound as NULL in SQL)
        } else {
            return 's'; // Default to string for all other types
        }
    }
}
?>