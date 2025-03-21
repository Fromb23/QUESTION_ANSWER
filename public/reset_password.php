<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Reset Password</h2>
        <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo "<p class='text-red-500 text-center mt-2'>" . htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') . "</p>";
                unset($_SESSION['error']);
            }
        ?>
        <form action="../processes/update_password.php" method="POST" class="mt-4">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
            <input type="password" name="new_password" placeholder="New Password" required class="w-full p-2 border rounded-md mb-2">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full p-2 border rounded-md mb-4">
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md">Update Password</button>
        </form>
    </div>

</body>
</html>