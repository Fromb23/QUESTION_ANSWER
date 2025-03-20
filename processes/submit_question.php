<?php
session_start();
require dirname(__DIR__) . "/config/db.php";
require dirname(__DIR__) . "/models/Question.php"; // Include the Question class

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

$user_id = $_SESSION['user_id'];
$description = trim($_POST['description']);

if (!empty($description)) {
    // Create an instance of the Question class
    $question = new Question($conn);

    // Use the createQuestion method to insert data
    $success = $question->createQuestion($user_id, $description);

    if ($success) {
        header("Location: /");
        exit();
    } else {
        echo "Error: Failed to post question!";
    }
} else {
    echo "Question cannot be empty!";
}
?>