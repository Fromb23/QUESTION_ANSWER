<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question and Answer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-md p-4 flex flex-col sm:flex-row justify-between items-center">
        <h1 class="text-xl font-bold">QUESTION AND ANSWER</h1>
        
        <?php if (isset($_SESSION['username'])): ?>
            <div class="relative mt-2 sm:mt-0">
                <button onclick="toggleDropdown()" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> ▼
                </button>
                <div id="dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white shadow-md rounded">
                    <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="settings.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                    <a href="logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="mt-2 sm:mt-0">
                <a href="public/signup.php" class="bg-blue-500 text-white px-4 py-2 rounded block sm:inline">Sign Up</a>
                <a href="public/signin.php" class="bg-gray-500 text-white px-4 py-2 rounded block sm:inline mt-2 sm:mt-0">Sign In</a>
            </div>
        <?php endif; ?>
    </header>

    <!-- Main Content Wrapper -->
    <div class="container mx-auto mt-4 flex flex-col sm:flex-row gap-4 flex-grow">

        <!-- Left Section (Questions & Users) -->
        <aside class="w-full sm:w-1/4 bg-white p-4 rounded shadow">
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

            <?php if (isset($_SESSION['username'])): ?>
                <!-- Show question posting form for logged-in users -->
                <form action="post_question.php" method="POST" class="mt-4">
                    <textarea name="question" placeholder="Ask a question..." required class="w-full p-2 border rounded-md"></textarea>
                    <button type="submit" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">Post Question</button>
                </form>
            <?php else: ?>
                <p class="text-gray-500 mt-4">Sign in to post questions and participate.</p>
            <?php endif; ?>
        </main>

        <!-- Right Section -->
        <aside class="w-full sm:w-1/4 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold">Latest Discussions</h2>
            <div class="mt-2 border-t pt-2">
                <p class="text-sm text-gray-600">No discussions yet...</p>
            </div>
        </aside>

    </div>

    <!-- Footer (Stays at Bottom) -->
    <footer class="bg-gray-900 text-white text-center p-2 mt-auto">
        &copy; 2025 Question and Answer Forum
    </footer>

    <script>
        function toggleDropdown() {
            let dropdown = document.getElementById("dropdown");
            dropdown.classList.toggle("hidden");
        }
    </script>

</body>
</html>