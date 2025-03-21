<?php
session_start();

include '../config/db.php';
include '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    $user = new User($conn); 

    if ($user->verifyEmail($email)) {
        header("Location: ../public/reset_password.php?email=" . urlencode($email));
        exit();
    } else {
        $_SESSION['error'] = "Invalid email address.";
        header("Location: ../public/forgot_password.php");
        exit();
    }
}
?>
