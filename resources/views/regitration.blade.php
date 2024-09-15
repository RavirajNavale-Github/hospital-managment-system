<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Register</h2>
        <form id="registration-form" class="p-4 shadow rounded bg-light">
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
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <!-- Bootstrap 5 JS & dependencies (Popper & Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- Fetch Method to handle form submission -->
    <script>
        document.getElementById('registration-form').addEventListener('submit', function (e) {
            e.preventDefault();
    
            // Create FormData object from the form
            const formData = new FormData(this);
    
            // Convert FormData to JSON format
            const formObject = Object.fromEntries(formData.entries());
            const jsonData = JSON.stringify(formObject);
    
            // Send data using Fetch API
            fetch('http://localhost:8000/api/signup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', 
                },
                body: jsonData,
            })
            .then(response => {
                // Check if response is ok and show appropriate message
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
    
                // Navigate to Login form after successful registration
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
