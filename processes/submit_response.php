<?php
session_start();
require __DIR__ . "/../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['username'])) {
        die("Error: User not logged in");
    }

    $question_id = $_POST['question_id'] ?? null;
    $parent_response_id = empty($_POST['parent_response_id']) ? NULL : $_POST['parent_response_id'];
    $username = $_SESSION['username'];
    $content = trim($_POST['content'] ?? '');

    if (!$question_id || empty($content)) {
        die("Error: Missing required fields");
    }

    $sql = "INSERT INTO responses (question_id, parent_response_id, username, content, created_at) 
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("iiss", $question_id, $parent_response_id, $username, $content);

    if ($stmt->execute()) {
        echo "Response submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: /");
    exit();
} else {
    echo "Invalid request method.";
}
?>