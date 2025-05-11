let user = {
    name: "",
    email: "",
    phoneNum: "",
    username: "",
    password: "",
    confirmPass: "",

    validateName: function() {
        if (this.name.trim() === "") {
            alert("Please enter your name.");
            return false;
        }
        return true;
    },

    validateEmail: function() {
        let emailPattern = /\S+@\S+\.\S+/;
        if (!emailPattern.test(this.email)) {
            alert("Please enter a valid email address.");
            return false;
        }
        return true;
    },

    validatePhoneNum: function() {
        if (this.phoneNum.length < 9) {
            alert("Phone number must be at least 9 characters long.");
            return false;
        }
        return true;
    },

    validateUsername: function() {
        if (this.username.trim() === "") {
            alert("Please enter your username.");
            return false;
        }
        return true;
    },

    validatePassword: function() {
        if (this.password.length < 6) {
            alert("Password must be at least 6 characters long.");
            return false;
        }
        return true;
    },

    validateConfirmPass: function() {
        if (this.confirmPass !== this.password) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
};

document.getElementById("registrationForm").addEventListener("submit", function(event) {
    event.preventDefault();

    user.name = document.getElementById("name").value;
    user.email = document.getElementById("email").value;
    user.phoneNum = document.getElementById("phoneNum").value;
    user.username = document.getElementById("username").value;
    user.password = document.getElementById("password").value;
    user.confirmPass = document.getElementById("confirmPass").value;

    let validatedInfo = user.validateName() && user.validateEmail() && user.validatePhoneNum() &&
                        user.validateUsername() && user.validatePassword() && user.validateConfirmPass();

    if (validatedInfo) {
        alert("Registration successful");
    }
});