document.addEventListener("DOMContentLoaded", function () {
    const usernameInput = document.getElementById("username");
    const currentPasswordInput = document.getElementById("current_password");
    const newPasswordInput = document.getElementById("new_password");
    const confirmNewPasswordInput = document.getElementById("confirm_new_password");
    const saveButton = document.getElementById("save_button");

    function checkForm() {
        const isUsernameChanged = usernameInput.value.trim() !== usernameInput.dataset.original;
        const isPasswordChanged = currentPasswordInput.value && newPasswordInput.value && confirmNewPasswordInput.value;
        saveButton.disabled = !(isUsernameChanged || isPasswordChanged);
    }

    usernameInput.addEventListener("input", checkForm);
    currentPasswordInput.addEventListener("input", checkForm);
    newPasswordInput.addEventListener("input", checkForm);
    confirmNewPasswordInput.addEventListener("input", checkForm);
});