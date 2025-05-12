// Function to validate form input
function validateForm() {
    const username = document.getElementById("user").value.trim();
    const password = document.getElementById("password").value.trim();

    // Check if the username field is empty
    if (username === "") {
        alert("Please enter your username or email.");
        return false;
    }

    // Check if the password field is empty
    if (password === "") {
        alert("Please enter your password.");
        return false;
    }

    return true;
}

// Function to handle form submission
function submitForm() {
    if (validateForm()) {
        // Form is valid, submit the form
        document.querySelector("form").submit();
    } else {
        // Form is invalid, prevent submission
        console.log("Form validation failed.");
    }
}

// Event listener for form submission
document.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission
    submitForm();
});
