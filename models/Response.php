<?php
class Response {
    private $conn;
    private $table = "responses";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new response (Must be linked to a question)
    public function createResponse($question_id, $user_id, $content) {
        $query = "INSERT INTO " . $this->table . " (question_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iis", $question_id, $user_id, $content);
        return $stmt->execute();
    }

    // Fetch all responses for a specific question
    public function getResponsesByQuestion($question_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE question_id = ? ORDER BY created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Edit a response
    public function updateResponse($id, $content) {
        $query = "UPDATE " . $this->table . " SET content = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $content, $id);
        return $stmt->execute();
    }

    // Delete a response
    public function deleteResponse($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>