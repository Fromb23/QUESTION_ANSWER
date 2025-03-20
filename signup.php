<!-- signup.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Sign Up</h2>
        <form action="signup_process.php" method="POST" class="mt-4">
            <input type="text" name="first_name" placeholder="First Name" required class="w-full p-2 border rounded-md mb-2">
            <input type="text" name="last_name" placeholder="Last Name" required class="w-full p-2 border rounded-md mb-2">
            <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded-md mb-2">
            <input type="text" name="username" placeholder="Username" required class="w-full p-2 border rounded-md mb-2">
            <input type="tel" name="phone" placeholder="Phone Number" required class="w-full p-2 border rounded-md mb-2">
            <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded-md mb-2">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required class="w-full p-2 border rounded-md mb-4">
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Sign Up</button>
        </form>
        <p class="mt-4 text-center text-gray-600">Already have an account? <a href="signin.php" class="text-blue-500">Sign In</a></p>
    </div>

</body>
</html>