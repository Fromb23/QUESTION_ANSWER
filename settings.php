<?php
session_start();
require __DIR__ . '/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /public/signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch user details
$query = $conn->prepare("SELECT profile_icon FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
$profile_icon = $user['profile_icon'] ?? 'default.png';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Profile Icon Update
    if (!empty($_FILES['profile_icon']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_icon"]["name"]);
        move_uploaded_file($_FILES["profile_icon"]["tmp_name"], $target_file);

        $stmt = $conn->prepare("UPDATE users SET profile_icon = ? WHERE id = ?");
        $stmt->bind_param("si", $target_file, $user_id);
        $stmt->execute();
        $_SESSION['profile_icon'] = $target_file;
    }

    // Username Update
    if (!empty($_POST['username']) && $_POST['username'] !== $username) {
        $new_username = trim($_POST['username']);
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $new_username, $user_id);
        $stmt->execute();
        $_SESSION['username'] = $new_username;
    }

    // Password Update
    if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_new_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($current_password, $hashed_password)) {
            if ($new_password === $confirm_new_password) {
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $hashed_new_password, $user_id);
                $stmt->execute();
            } else {
                echo "<script>alert('New passwords do not match');</script>";
            }
        } else {
            echo "<script>alert('Incorrect current password');</script>";
        }
    }
    header("Location: settings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center p-6">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-4">Settings</h2>

        <div class="flex flex-col items-center">
            <img src="<?php echo htmlspecialchars($profile_icon); ?>" class="w-20 h-20 rounded-full border mb-2" alt="Profile Icon">
            <form action="settings.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_icon" accept="image/*" class="block w-full text-sm mb-3">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
            </form>
        </div>

        <form action="settings.php" method="POST" class="mt-4" id="profileForm">
            <label class="block text-gray-700">Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" class="w-full p-2 border rounded" id="username">

            <label class="block text-gray-700 mt-4">Current Password</label>
            <input type="password" name="current_password" class="w-full p-2 border rounded" id="current_password">
            <p id="passwordError" class="text-red-500 text-sm hidden">Incorrect current password</p>

            <!-- Verify Password Button (Hidden by Default) -->
            <button type="button" id="verifyPasswordButton" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hidden">Verify Password</button>

            <div id="passwordFields" class="hidden">
                <label class="block text-gray-700 mt-2">New Password</label>
                <input type="password" name="new_password" id="new_password" class="w-full p-2 border rounded">
                <label class="block text-gray-700 mt-2">Confirm New Password</label>
                <input type="password" name="confirm_new_password" id="confirm_new_password" class="w-full p-2 border rounded">
            </div>

            <p id="errorMessage"></p>

            <button type="submit" id="saveButton" class="mt-4 bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>Save Changes</button>
        
            <div class="flex justify-end">
                <a href="/" class="text-blue-500 hover:text-blue-700">Back to Home</a>
            </div>
        </form>
    

        <script src="js/settings.js"></script>
    </body>
</html>