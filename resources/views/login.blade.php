<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to left, #00c6ff, #0072ff);
            font-family: Arial, sans-serif;
        }
        .container {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
        .form-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0072ff;
        }
        .btn-primary {
            background: linear-gradient(45deg, #0072ff, #00c6ff);
            border: none;
            color: white;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #00c6ff, #0072ff);
        }
        .d-flex {
            gap: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Login</h2>
            <form id="login-form">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <button id="register" type="button" class="btn btn-secondary w-100">Register</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS & dependencies (Popper & Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('login-form').addEventListener('submit', function (e) {
            e.preventDefault();

            // Create FormData object from the form
            const formData = new FormData(this);

            // Convert FormData to JSON format
            const formObject = Object.fromEntries(formData.entries());
            const jsonData = JSON.stringify(formObject);

            fetch('http://localhost:8000/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',  
                },
                body: jsonData,
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || `HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                const token = data.token;
                const tokenType = data.token_type;
                
                localStorage.setItem('token', token);
                localStorage.setItem('token_type', tokenType);
                
                alert('Login successful! Token and token type stored in localStorage.');
                
                window.location.href = 'dashboard';
            })
            .catch(error => {
                alert('Error during login: ' + error.message);
                console.error('Error:', error);
            });
        });

        document.getElementById('register').addEventListener('click', function () {
            window.location.href = 'registration'; // Corrected URL
        });
    </script>
</body>
</html>
