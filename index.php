<?php
session_start();
$profile_image = $_SESSION['profile_image'] ?? null;
$username = $_SESSION['username'] ?? null;
$first_letter = $username ? strtoupper(substr($username, 0, 1)) : null;
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
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">QUESTION AND ANSWER</h1>

        <?php if ($username): ?>
            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-full">
                    <?php if ($profile_image): ?>
                        <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile" class="w-8 h-8 rounded-full mr-2">
                    <?php else: ?>
                        <span class="w-8 h-8 flex items-center justify-center bg-gray-300 text-gray-700 font-bold rounded-full mr-2">
                            <?php echo $first_letter; ?>
                        </span>
                    <?php endif; ?>
                    <span class="hidden sm:inline">Welcome, <?php echo htmlspecialchars($username); ?> ▼</span>
                </button>

                <!-- Dropdown -->
                <div id="dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white shadow-md rounded-lg">
                    <a href="settings.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                    <a href="public/logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="flex gap-2">
                <a href="public/signup.php" class="bg-blue-500 text-white px-4 py-2 rounded">Sign Up</a>
                <a href="public/signin.php" class="bg-gray-500 text-white px-4 py-2 rounded">Sign In</a>
            </div>
        <?php endif; ?>
    </header>

    <!-- Main Content Wrapper -->
    <div class="container mx-auto mt-4 flex flex-col sm:flex-row gap-4 flex-grow px-2">

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

            <?php if ($username): ?>
                <!-- Show question posting form for logged-in users -->
                <form action="processes/submit_question.php" method="POST" class="mt-4">
                    <textarea name="description" placeholder="Ask a question..." required class="w-full p-2 border rounded-md"></textarea>
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