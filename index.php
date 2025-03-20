<?php
session_start();
require __DIR__ . "/config/db.php";
require __DIR__ . "/models/Question.php";
require __DIR__ . "/models/Response.php";

$questionModel = new Question($conn);
$questions = $questionModel->getAllQuestions();
$responseModel = new Response($conn);

$profile_image = $_SESSION['profile_image'] ?? null;
$username = $_SESSION['username'] ?? null;
$first_letter = $username ? strtoupper(substr($username, 0, 1)) : null;

$selected_question_id = $_GET['question_id'] ?? $_SESSION['selected_question_id'] ?? null;

if ($selected_question_id) {
    $_SESSION['selected_question_id'] = $selected_question_id;
    $selected_question = $questionModel->getQuestionById($selected_question_id);
    $responses = $responseModel->getResponsesByQuestionId($selected_question_id);
} else {
    $selected_question = null;
    $responses = [];
}
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

    <div class="container mx-auto mt-4 flex flex-col sm:flex-row gap-4 flex-grow px-2">

        <aside class="w-full sm:w-1/4 bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Latest Questions</h2>
            <?php if (!empty($questions)): ?>
                <?php foreach ($questions as $q): ?>
                    <div class="question-card border-b border-gray-300 pb-2 mb-2 cursor-pointer" onclick="location.href='?question_id=<?= $q['id'] ?>'">
                        <p class="text-md font-medium"><?= htmlspecialchars($q['description']) ?></p>
                        <p class="text-sm text-gray-600">By <strong><?= htmlspecialchars($q['username']) ?></strong> - <?= date('F j, Y, g:i a', strtotime($q['created_at'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">No questions in this forum yet.</p>
            <?php endif; ?>
        </aside>

        <main id="main-content" class="flex-1 bg-white p-4 rounded shadow">
            <?php if ($selected_question): ?>
                <h2 class="text-xl font-semibold"><?= htmlspecialchars($selected_question['description']) ?></h2>
                <p class="text-gray-700 mt-2"><?= htmlspecialchars($selected_question['details'] ?? 'No details provided.') ?></p>

                <div id="response-section" class="mt-4">
                    <h3 class="text-lg font-semibold">Responses</h3>
                    <div id="response-list" class="mt-2 border-t pt-2 text-gray-700">
                        <?php if (!empty($responses)): ?>
                            <?php foreach ($responses as $response): ?>
                                <?Php $username = $response['username'] ?? 'Anonymous'; ?>
                                <p class="border-b py-2"><?= htmlspecialchars($response['content']) ?> - <span class="text-sm text-gray-500"><?= htmlspecialchars($response['username']) ?></span></p>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-gray-500">No responses yet. Be the first to respond!</p>
                        <?php endif; ?>
                    </div>

                    <?php if ($username): ?>
                        <form action="processes/submit_response.php" method="POST" class="mt-4">
                            <input type="hidden" name="question_id" value="<?= $selected_question_id ?>">
                            <textarea name="content" placeholder="Post a response..." required class="w-full p-2 border rounded-md"></textarea>
                            <button type="submit" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">Post Response</button>
                        </form>
                    <?php else: ?>
                        <p class="text-gray-500 mt-4">Sign in to post responses.</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <h2 class="text-xl font-semibold">Welcome to the Forum</h2>
                <p class="text-gray-700 mt-2">Ask questions, get answers, and share knowledge!</p>
            <?php endif; ?>

            <hr class="my-4">
            <h3 class="text-lg font-semibold">Ask a New Question</h3>
            <?php if ($username): ?>
                <form action="processes/submit_question.php" method="POST" class="mt-4">
                    <textarea name="description" placeholder="Ask a question..." required class="w-full p-2 border rounded-md"></textarea>
                    <button type="submit" class="mt-2 bg-green-500 text-white py-2 px-4 rounded">Ask Question</button>
                </form>
            <?php else: ?>
                <p class="text-gray-500 mt-4">Sign in to ask questions.</p>
            <?php endif; ?>
        </main>

        <aside class="w-full sm:w-1/4 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-semibold">Latest Discussions</h2>
            <div class="mt-2 border-t pt-2">
                <p class="text-sm text-gray-600">No discussions yet...</p>
            </div>
        </aside>
    </div>

    <footer class="bg-gray-900 text-white text-center p-2 mt-auto">
        &copy; 2025 Question and Answer Forum
    </footer>

    <script>
        function toggleDropdown() {
            document.getElementById("dropdown").classList.toggle("hidden");
        }
    </script>

</body>
</html>