document.addEventListener('DOMContentLoaded', function() {
    // Modal and toggle button elements
    const logInButton = document.getElementById('log-in-button');
    const modal = document.getElementById('log-in-modal');
    const closeButton = document.getElementById('close-modal');
    
    // Elements for login and register forms and message areas
    const loginForm = document.getElementById('login-form-content');
    const registerForm = document.getElementById('register-form-content');
    const loginMessage = document.getElementById('login-message');
    const registerMessage = document.getElementById('register-message');
    const showRegister = document.getElementById('show-register');
    const showLogin = document.getElementById('show-login');

    // Open the modal and display login form when "Sign Up or Log In" button is clicked
    logInButton.addEventListener('click', function() {
        console.log('Log In button clicked');
        modal.style.display = 'flex';
        loginForm.parentElement.style.display = 'block';
        registerForm.parentElement.style.display = 'none';
    });

    // Close the modal when the close button is clicked
    closeButton.addEventListener('click', function() {
        console.log('Close button clicked');
        modal.style.display = 'none';
    });

    // Close modal if clicking outside the modal content area
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            console.log('Clicked outside modal, closing');
            modal.style.display = 'none';
        }
    });

    // Toggle to show the register form
    showRegister.addEventListener('click', function(event) {
        event.preventDefault();
        console.log('Show Register clicked');
        loginForm.parentElement.style.display = 'none';
        registerForm.parentElement.style.display = 'block';
        loginMessage.textContent = ''; // Clear any previous messages
    });

    // Toggle to show the login form
    showLogin.addEventListener('click', function(event) {
        event.preventDefault();
        console.log('Show Login clicked');
        loginForm.parentElement.style.display = 'block';
        registerForm.parentElement.style.display = 'none';
        registerMessage.textContent = ''; // Clear any previous messages
    });

    // Handle login form submission with AJAX
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        console.log('Login form submitted');
        // Collect form data
        const formData = new FormData(loginForm);

        // Send the form data using fetch
        fetch('../handlers/login_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Login successful, redirecting to account page');
                // Login successful, redirect to the account page
                window.location.href = '../views/';
            } else {
                console.error('Login failed:', data.error);
                // Display error message if login failed
                loginMessage.textContent = data.error || 'Invalid username or password.';
                loginMessage.style.color = 'red';
            }
        })
        .catch(error => {
            console.error('Error occurred during login:', error);
            loginMessage.textContent = 'An error occurred. Please try again.';
            loginMessage.style.color = 'red';
        });
    });

    // Handle registration form submission with AJAX
    registerForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        console.log('Register form submitted');
        // Collect form data
        const formData = new FormData(registerForm);

        // Send the form data using fetch
        fetch('../handlers/register_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Registration successful');
                // Display success message and show login form
                registerMessage.textContent = 'Registration successful! Please log in.';
                registerMessage.style.color = 'green';

                // Switch to login form after a short delay
                setTimeout(() => {
                    loginForm.parentElement.style.display = 'block';
                    registerForm.parentElement.style.display = 'none';
                    registerMessage.textContent = ''; // Clear the message
                }, 1500);
            } else {
                console.error('Registration failed:', data.error);
                // Display error message if registration failed
                registerMessage.textContent = data.error || 'Registration failed. Please try again.';
                registerMessage.style.color = 'red';
            }
        })
        .catch(error => {
            console.error('Error occurred during registration:', error);
            registerMessage.textContent = 'An error occurred. Please try again.';
            registerMessage.style.color = 'red';
        });
    });
});
