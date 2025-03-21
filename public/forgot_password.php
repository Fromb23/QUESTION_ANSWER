<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Forgot Password</h2>
        <p class="text-gray-600 text-center">Enter your email to reset password</p>
        <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo "<p class='text-red-500 text-center mt-2'>" . $_SESSION['error'] . "</p>";
                unset($_SESSION['error']);
            }
        ?>
        <form action="../processes/verify_email.php" method="POST" class="mt-4">
            <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded-md mb-4">
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Verify Email</button>
        </form>
        <p class="mt-4 text-center text-gray-600"><a href="signin.php" class="text-blue-500">Back to Sign In</a></p>
    </div>

</body>
</html>