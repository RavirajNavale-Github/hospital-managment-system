<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(45deg, #1155cb, #a6c0fe);
            font-family: Arial, sans-serif;
            height: 100vh;
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
            max-width: 500px;
            margin: auto;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #1155cb;
        }
        .btn-primary {
            background: linear-gradient(45deg, #0072ff, #00c6ff);
            border: none;
            color: white;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #00c6ff, #0072ff);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Register</h2>
            <form id="registration-form">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS & dependencies (Popper & Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('registration-form').addEventListener('submit', function (e) {
            e.preventDefault();
    
            // Create FormData object from the form
            const formData = new FormData(this);
    
            // Convert FormData to JSON format
            const formObject = Object.fromEntries(formData.entries());
            const jsonData = JSON.stringify(formObject);
    
            fetch('http://localhost:8000/api/signup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', 
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
                alert('Registration successful');
                console.log(data);
    
                window.location.href = 'login';
            })
            .catch(error => {
                alert('Error during registration: ' + error.message);
                console.error('Error:', error);
            });
        });
    </script>
    
</body>
</html>
