<!-- signin.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="flex max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Left Section (Image) -->
        <div class="w-1/2 hidden md:block">
            <img src="signin-image.jpg" alt="Sign In Image" class="h-full w-full object-cover">
        </div>

        <!-- Right Section (Form) -->
        <div class="w-full md:w-1/2 p-6">
            <h2 class="text-2xl font-bold text-center text-gray-700">Welcome Back!</h2>
            <form action="signin_process.php" method="POST" class="mt-4">
                <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded-md mb-2">
                <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded-md mb-4">
                <a href="#" class="text-blue-500 text-sm block text-right mb-4">Forgot Password?</a>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Sign In</button>
            </form>
            <p class="mt-4 text-center text-gray-600">New here? <a href="signup.php" class="text-blue-500">Create an account</a></p>
        </div>
    </div>

</body>
</html>