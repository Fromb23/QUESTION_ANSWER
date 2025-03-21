<?php
include '../config/db.php';
include '../models/User.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['error'] = "Password fields cannot be empty.";
        header("Location: ../views/reset_password.php?email=" . urlencode($email));
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../public/reset_password.php?email=" . urlencode($email));
        exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $user = new User($conn);
    if ($user->updatePassword($email, $hashedPassword)) {
        $_SESSION['success'] = "Password updated successfully!";
        header("Location: ../public/signin.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating password. Please try again.";
        header("Location: ../public/reset_password.php?email=" . urlencode($email));
        exit();
    }
}
?>