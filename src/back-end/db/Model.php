<?php
require_once("Database.php");

class Model {
    protected $conn;
    protected $table;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function find(array $criteria = []) {
        if (empty($criteria)) {
            return $this->fetchAll();
        }

        $conditions = [];
        $values = [];
        $types = '';

        foreach ($criteria as $column => $value) {
            $conditions[] = "$column = ?";
            $values[] = &$value;

            if (is_int($value)) {
                $types .= 'i'; 
            } elseif (is_double($value)) {
                $types .= 'd'; 
            } else {
                $types .= 's';
            }
        }

        $whereClause = implode(" AND ", $conditions);
        $query = "SELECT * FROM $this->table WHERE $whereClause";

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

        // Fetch all results
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $stmt->close();
        return $rows;
    }

    private function fetchAll() {
        $query = "SELECT * FROM $this->table";
        $result = $this->conn->query($query);

        if (!$result) {
            throw new Exception("Query failed: " . $this->conn->error);
        }

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }
}
?>