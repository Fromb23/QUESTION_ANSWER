<?php
include '../config/db.php';
include '../models/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
 
    if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($phone) || empty($password) || empty($confirm_password)) {
        header("Location: ../public/signup.php?error=All fields are required");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: ../public/signup.php?error=Passwords do not match");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../public/signup.php?error=Invalid email format");
        exit();
    }

    $user = new User($conn);

	if ($user->checkUserExists($email, $username)) {
		header("Location: ../public/signup.php?error=Email or Username already taken");
		exit();
	}

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($user->register($firstname, $lastname, $email, $username, $phone, $hashed_password)) {
        header("Location: ../public/signin.php?success=Account created successfully! Please sign in.");
		var_dump($_POST);
        exit();
    } else {
        header("Location: ../public/signup.php?error=Failed to register. Try again.");
        exit();
    }
}
?>