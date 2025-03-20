<?php
session_start();
require __DIR__ . "/../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['username'])) {
        die("Error: User not logged in");
    }

    // Get form data
    $question_id = $_POST['question_id'] ?? null;
    $username = $_SESSION['username']; // Get username from session
    $content = trim($_POST['content'] ?? '');

    // Validate input
    if (!$question_id || empty($content)) {
        die("Error: Missing required fields");
    }

    // Prepare SQL query
    $sql = "INSERT INTO responses (question_id, username, content, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    // Check if the query preparation succeeded
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("iss", $question_id, $username, $content);

    if ($stmt->execute()) {
        echo "Response submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();

    // Redirect to the homepage
    header("Location: /");
    exit();
} else {
    echo "Invalid request method.";
}
?>