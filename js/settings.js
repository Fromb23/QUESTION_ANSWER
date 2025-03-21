document.getElementById("current_password").addEventListener("input", function () {
    const verifyPasswordButton = document.getElementById("verifyPasswordButton");

    if (this.value.length > 0) {
        verifyPasswordButton.classList.remove("hidden");
    } else {
        verifyPasswordButton.classList.add("hidden");
    }
});

document.getElementById("saveButton").addEventListener("click", function (e) {
    e.preventDefault();

    const newPassword = document.getElementById("new_password").value;
    const confirmNewPassword = document.getElementById("confirm_new_password").value;

    const errorMessageElement = document.getElementById("errorMessage");

    if (newPassword !== confirmNewPassword) {
        errorMessageElement.innerHTML = "<p>New passwords do not match.</p>";
        errorMessageElement.classList.remove("hidden");
        errorMessageElement.classList.add("text-red-500", "text-lg", "mt-2"); 
        return;
    }
    errorMessageElement.innerHTML = "";
    errorMessageElement.classList.add("hidden");

    const form = document.getElementById("profileForm");
    form.submit();
});

document.getElementById("verifyPasswordButton").addEventListener("click", function () {
    const currentPassword = document.getElementById("current_password").value;
    const passwordFields = document.getElementById("passwordFields");
    const passwordError = document.getElementById("passwordError");
    const saveButton = document.getElementById("saveButton");

    fetch("public/validate_password.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `current_password=${encodeURIComponent(currentPassword)}`,
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        if (data.success) {
            passwordFields.classList.remove("hidden");
            passwordError.classList.add("hidden");
            saveButton.disabled = false;
        } else {
            passwordFields.classList.add("hidden");
            passwordError.classList.remove("hidden");
            saveButton.disabled = true;
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});

// Enable the save button when any input field is modified
document.querySelectorAll("input").forEach(input => {
    input.addEventListener("input", () => {
        const saveButton = document.getElementById("saveButton");
        saveButton.classList.remove("bg-gray-400", "cursor-not-allowed");
        saveButton.classList.add("bg-blue-500", "cursor-pointer");
        saveButton.disabled = false;
    });
});