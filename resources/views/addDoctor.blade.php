<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Add Doctor</h2>
        <form id="addDoctorForm" enctype="multipart/form-data" class="p-4 shadow rounded bg-light">
            <div class="mb-3">
                <label for="profile_image" class="form-label">Profile Image (optional):</label>
                <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>

            <div class="mb-3">
                <label for="department" class="form-label">Department:</label>
                <input type="text" class="form-control" id="department" name="department" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Add Doctor</button>
        </form>
    </div>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to check if the user is authenticated
        function checkAuthentication() {
            const token = localStorage.getItem('token');
            if (!token) {
                // Redirect to login page if no token is found
                window.location.href = 'login';
            }
        }

        // Call the function on page load
        checkAuthentication();
        
        document.getElementById('addDoctorForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Prepare form data
            let formData = new FormData(this);
            
            // Get token from localStorage
            let token = localStorage.getItem('token');
            
            fetch('http://localhost:8000/api/doctors', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return response.json().then(error => {
                        throw new Error('Failed to add doctor: ' + (error.message || 'Unknown error'));
                    });
                }
            })
            .then(result => {
                // Doctor added successfully
                alert('Doctor added successfully!');
                console.log(result);
                
                // Redirect to the dashboard after a successful addition
                window.location.href = 'dashboard';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            });
        });
    </script>

</body>
</html>
