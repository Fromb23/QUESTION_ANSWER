// Toggle user dropdown
function toggleDropdown() {
    document.getElementById("dropdown").classList.toggle("hidden");
}

document.addEventListener("DOMContentLoaded", function () {
    // Initialize Lucide icons
    lucide.createIcons();

    // Handle double-click to show reply form
    document.querySelectorAll(".response-item").forEach((item) => {
        item.addEventListener("dblclick", (e) => {
            const responseId = item.getAttribute("data-id");
            const replyForm = document.querySelector(
                `.response-reply-form[data-id="${responseId}"]`
            );
            replyForm.classList.toggle("hidden");
        });
    });

    // Handle reply submission
    document.querySelectorAll(".send-reply-btn").forEach((button) => {
        button.addEventListener("click", (e) => {
            const responseId = button.getAttribute("data-id");
            const replyInput = document.querySelector(
                `.response-reply-form[data-id="${responseId}"] input`
            );
            const replyContent = replyInput.value.trim();

            if (replyContent) {
                // Send the reply to the server
                fetch("processes/submit_response.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: new URLSearchParams({
                        question_id: document.querySelector("input[name='question_id']").value,
                        content: replyContent,
                        parent_response_id: responseId,
                    }),
                })
                    .then((response) => response.text())
                    .then((data) => {
                        location.reload(); // Reload the page to show the new reply
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            }
        });
    });

    // Handle like/unlike, edit, delete, and share buttons
    document.querySelectorAll(".like-btn, .edit-btn, .delete-btn, .share-btn").forEach((button) => {
        button.addEventListener("click", (e) => {
            const action = button.classList.contains("like-btn") ? "like" :
                          button.classList.contains("edit-btn") ? "edit" :
                          button.classList.contains("delete-btn") ? "delete" : "share";
            const responseId = button.getAttribute("data-id");

            if (action === "delete") {
                if (!confirm("Are you sure you want to delete this response?")) return;
            }

            fetch(`processes/${action}_response.php`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: new URLSearchParams({ response_id: responseId }),
            })
                .then((response) => response.text())
                .then((data) => {
                    if (action === "delete") {
                        location.reload(); // Reload the page after deletion
                    } else {
                        alert(`${action} action successful!`);
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    });
});