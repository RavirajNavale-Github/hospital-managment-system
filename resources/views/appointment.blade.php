<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(45deg, #1155cb, #a6c0fe);
            font-family: Arial, sans-serif;
        }
        .form-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto;
            max-width: 600px;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
        .btn-custom {
            background: linear-gradient(45deg, #1155cb, #2575fc);
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background: linear-gradient(45deg, #2575fc, #1155cb);
        }
        .text-muted {
            font-size: 0.9rem;
        }
        .alert-custom {
            display: none;
            margin-top: 1rem;
        }
        .container {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4 text-white">Book an Appointment</h2>
        <div class="form-container">
            <form id="appointment-form">
                <div class="mb-3">
                    <label for="patient_name" class="form-label">Patient Name</label>
                    <input type="text" class="form-control" id="patient_name" name="patient_name" required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="booking_date" class="form-label">Booking Date</label>
                    <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" required>
                </div>
                <div class="mb-3">
                    <label for="speciality" class="form-label">Speciality</label>
                    <input type="text" class="form-control" id="speciality" name="speciality" required>
                </div>
                <div class="mb-3">
                    <label for="doctor" class="form-label">Doctor</label>
                    <input type="text" class="form-control" id="doctor" name="doctor" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" required>
                </div>
                <div class="mb-3">
                    <label for="details" class="form-label">Details</label>
                    <textarea class="form-control" id="details" name="details" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-custom">Submit</button>
                <div class="alert alert-success alert-custom" role="alert" id="success-message">
                    Appointment booked successfully!
                </div>
                <div class="alert alert-danger alert-custom" role="alert" id="error-message">
                    Error booking appointment. Please try again.
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS & dependencies (Popper & Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('appointment-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Convert FormData to JSON format
            const formObject = Object.fromEntries(formData.entries());
            const jsonData = JSON.stringify(formObject);

            fetch('http://localhost:8000/api/appointments', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',      
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
                document.getElementById('success-message').style.display = 'block';
                document.getElementById('error-message').style.display = 'none';
                console.log(data);
            })
            .catch(error => {
                document.getElementById('error-message').style.display = 'block';
                document.getElementById('success-message').style.display = 'none';
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
