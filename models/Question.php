<?php
class Question {
    private $conn;
    private $table = "questions";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new question
    public function createQuestion($user_id, $title, $description) {
        $query = "INSERT INTO " . $this->table . " (user_id, title, description) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iss", $user_id, $title, $description);
        return $stmt->execute();
    }

    // Fetch all questions
    public function getAllQuestions() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Edit a question
    public function updateQuestion($id, $title, $description) {
        $query = "UPDATE " . $this->table . " SET title = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $title, $description, $id);
        return $stmt->execute();
    }

    // Delete a question
    public function deleteQuestion($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>