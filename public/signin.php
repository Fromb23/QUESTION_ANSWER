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

            <!-- Error Message -->
            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-100 text-red-700 p-2 rounded-md mb-4 text-center">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Success Message -->
            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-100 text-green-700 p-2 rounded-md mb-4 text-center">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <!-- Sign In Form -->
            <form action="../processes/signin_process.php" method="POST" class="mt-4">
                <!-- Email Input -->
                <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded-md mb-2" aria-label="Email">

                <!-- Password Input -->
                <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded-md mb-4" aria-label="Password">

                <!-- Forgot Password Link -->
                <a href="#" class="text-blue-500 text-sm block text-right mb-4" aria-label="Forgot Password">Forgot Password?</a>

                <!-- Submit Button -->
                <button type="submit" id="signin-btn" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">
                    Sign In
                </button>

                <!-- Loading Message -->
                <p id="loading-message" class="text-center mt-2 text-gray-500" style="display: none;">Logging in...</p>
            </form>

            <!-- Sign Up Link -->
            <p class="mt-4 text-center text-gray-600">New here? <a href="signup.php" class="text-blue-500">Create an account</a></p>
        </div>
    </div>

    <!-- JavaScript for Loading Message -->
    <script>
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('loading-message').style.display = 'block';
            document.getElementById('signin-btn').disabled = true;
        });
    </script>
</body>
</html>