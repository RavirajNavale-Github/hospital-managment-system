<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Login</h2>
        <form id="login-form" class="p-4 shadow rounded bg-light">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <button id="register" type="button" class="btn btn-primary">Register</button>
        </form>
    </div>

    <!-- Bootstrap 5 JS & dependencies (Popper & Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Fetch Method to handle form submission and store token & token_type -->
    <script>
        document.getElementById('login-form').addEventListener('submit', function (e) {
            e.preventDefault();

            // Create FormData object from the form
            const formData = new FormData(this);

            // Convert FormData to JSON format
            const formObject = Object.fromEntries(formData.entries());
            const jsonData = JSON.stringify(formObject);

            // Send data using Fetch API
            fetch('http://localhost:8000/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Tell server we're sending JSON
                    'Accept': 'application/json',       // Expect JSON response
                },
                body: jsonData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Assuming the response contains both 'token' and 'token_type'
                const token = data.token;
                const tokenType = data.token_type;
                
                // Store token and token_type in localStorage
                localStorage.setItem('token', token);
                localStorage.setItem('token_type', tokenType);
                
                alert('Login successful, token and token type stored in localStorage');
                console.log('Token:', token);
                console.log('Token Type:', tokenType);
            })
            .catch(error => {
                alert('Error during login: ' + error.message);
                console.error('Error:', error);
            });
        });

        // Navigate to Dashboard form when "Login" button is clicked
        document.getElementById('login-form').addEventListener('submit', function () {
            window.location.href = 'dashboard'; 
        });

        // Navigate to Registration form when "SignUp" button is clicked
        document.getElementById('register').addEventListener('click', function () {
            window.location.href = 'regitration'; 
        });
    </script>
</body>
</html>
