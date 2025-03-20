<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StackOverflow Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Header -->
    <header class="bg-white shadow-md p-4">
        <h1 class="text-xl font-bold text-center">QUESTION AND ANSWER</h1>
    </header>

    <div class="container mx-auto mt-4 flex gap-4">

        <!-- Left Section (Questions & Users) -->
        <aside class="w-1/4 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold">Questions</h2>
            <div class="mt-2 border-t pt-2">
                <p class="text-sm text-gray-600">No questions yet...</p>
            </div>

            <h2 class="text-lg font-semibold mt-4">Users</h2>
            <div class="mt-2 border-t pt-2">
                <p class="text-sm text-gray-600">No users registered...</p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Welcome to the Forum</h2>
            <p class="text-gray-700 mt-2">Ask questions, get answers, and share knowledge!</p>
        </main>

        <!-- Right Section (Signup & Signin) -->
        <aside class="w-1/4 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold">Join Us</h2>
            <div class="mt-2 flex flex-col gap-2">
                <a href="signup.php" class="bg-blue-500 text-white p-2 rounded text-center">Sign Up</a>
                <a href="signin.php" class="bg-gray-500 text-white p-2 rounded text-center">Sign In</a>
            </div>
        </aside>

    </div>

    <!-- Footer -->
    <footer class="absolute bottom-0 mt-4 bg-gray-900 text-white text-center w-full p-2">
        &copy; 2025 Quesion and Answer Forum
    </footer>

</body>
</html>