<?php
session_start();
require_once '../config/db.php';
require_once '../models/User.php';

global $conn;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        header("Location: ../public/signin.php?error=Email and Password are required");
        exit();
    }

    $user = new User($conn);
    $loggedInUser = $user->login($email, $password);

    if ($loggedInUser) {
        session_regenerate_id(true);

        // Store user data in session
        $_SESSION['useer_id'] = $loggedInUser['id'];
        $_SESSION['email'] = $loggedInUser['email'];
        $_SESSION['firstname'] = $loggedInUser['firstname'];
        $_SESSION['lastname'] = $loggedInUser['lastname'];
        $_SESSION['username'] = $loggedInUser['username'];

        header("Location: ../index.php");
        exit();
    } else {
        error_log("Login failed for email: $email");
        header("Location: ../public/signin.php?error=Invalid email or password");
        exit();
    }
} else {
    header("Location: ../public/signin.php");
    exit();
}
?>