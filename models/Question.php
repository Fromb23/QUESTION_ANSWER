<?php
class Question {
    private $conn;
    private $table = "questions";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new question
    public function createQuestion($user_id, $description) {
        $query = "INSERT INTO " . $this->table . " (user_id, description, created_at) VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("is", $user_id, $description);
        return $stmt->execute();
    }

    // Fetch all questions
    public function getAllQuestions() {
        $query = "SELECT q.id, q.description, q.created_at, u.username 
                  FROM " . $this->table . " q
                  JOIN users u ON q.user_id = u.id
                  ORDER BY q.created_at DESC";
    
        $result = $this->conn->query($query);
    
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }    

    // Fetch a specific question
    public function getQuestionById($id) {
        $query = "SELECT q.id, q.description, q.created_at, u.username 
                  FROM " . $this->table . " q
                  JOIN users u ON q.user_id = u.id
                  WHERE q.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
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