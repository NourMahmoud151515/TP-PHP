<?php
class Repository {
    private $conn;
    private $table;

    public function __construct($conn, $table) {
        $this->conn = $conn;
        $this->table = $table;
    }

    public function findAll() {
        $result = $this->conn->query("SELECT * FROM {$this->table}");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");

        $stmt->bind_param(str_repeat("s", count($data)), ...array_values($data));
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
