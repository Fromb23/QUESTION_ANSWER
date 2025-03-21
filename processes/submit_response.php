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

    // ✅ Fetch user_id based on the session username
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    
    if (!$stmt->fetch()) {
        die("Error: User not found");
    }
    $stmt->close();

    // ✅ Ensure user_id is set correctly
    if (!$user_id) {
        die("Error: Unable to retrieve user ID");
    }

    /**
     * Recursively fetch the hierarchy of usernames leading to the top parent.
     */
    function getMentions($conn, $parent_response_id) {
        $mentions = [];
        $current_parent_id = $parent_response_id;

        while (!is_null($current_parent_id)) {
            $stmt = $conn->prepare("SELECT parent_response_id, username FROM responses WHERE id = ?");
            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param("i", $current_parent_id);
            $stmt->execute();
            $stmt->bind_result($next_parent_id, $parent_username);

            if ($stmt->fetch()) {
                if (!in_array($parent_username, $mentions)) {
                    $mentions[] = $parent_username; // Keep order from top parent to immediate parent
                }
                $current_parent_id = $next_parent_id;
            } else {
                break;
            }

            $stmt->close();
        }

        return array_reverse($mentions); // Maintain top-to-bottom hierarchy
    }

    // Fetch mentions correctly
    $mentions = getMentions($conn, $parent_response_id);
    $mention_string = empty($mentions) ? "" : "@" . implode(" @", $mentions) . " ";
    $formatted_content = $mention_string . $content;

    // ✅ Modify INSERT statement to include `user_id`
    $sql = "INSERT INTO responses (question_id, parent_response_id, user_id, content, created_at) 
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("iiis", $question_id, $parent_response_id, $user_id, $formatted_content);

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