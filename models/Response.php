<?php
class Response {
    private $conn;
    private $table = "responses";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new response (Supports nested replies)
public function createResponse($question_id, $user_id, $content, $parent_response_id = null) {
    $query = "INSERT INTO " . $this->table . " (question_id, user_id, content, parent_response_id) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    
    // Handle NULL properly
    if ($parent_response_id === null) {
        $stmt->bind_param("iis", $question_id, $user_id, $content);
    } else {
        $stmt->bind_param("iisi", $question_id, $user_id, $content, $parent_response_id);
    }

    return $stmt->execute();
}



public function getResponsesByQuestionId($questionId) {
    $sql = "SELECT r.*, u.username 
            FROM responses r
            JOIN users u ON r.user_id = u.id
            WHERE r.question_id = ?
            ORDER BY r.created_at ASC";
    
    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $this->conn->error); // Print the SQL error
    }
    $stmt->bind_param("i", $questionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $responses = $result->fetch_all(MYSQLI_ASSOC);

    $responseMap = [];
    $nestedResponses = [];

    // First, store all responses in a flat array
    foreach ($responses as $response) {
        $response['children'] = [];
        $responseMap[$response['id']] = $response;
    }

    // Then, build the nested structure
    foreach ($responseMap as $id => &$response) {
        if ($response['parent_response_id'] !== null && isset($responseMap[$response['parent_response_id']])) {
            $responseMap[$response['parent_response_id']]['children'][] = &$response;
        } else {
            $nestedResponses[] = &$response;
        }
    }

    return $nestedResponses;
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