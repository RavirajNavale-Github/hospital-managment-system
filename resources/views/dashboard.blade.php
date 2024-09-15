<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
        }
        .left-section {
            width: 30%;
            padding: 20px;
        }
        .right-section {
            width: 70%;
            padding: 20px;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
        }
        .doctor-card {
            margin-bottom: 20px;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="container mt-4 shadow rounded bg-light" >
        <!-- Top Section: Display Number of Appointments and Doctors -->
        <div id="dashboard-info" class="text-center mb-4">
            <h3>Today's Appointments: <span id="appointments-count">0</span></h3>
            <h3>Doctors Registered: <span id="doctors-count">0</span></h3>
        </div>

        <!-- Dashboard Main Layout -->
        <div class="dashboard-container">
            <!-- Left Section: Buttons -->
            <div class="left-section bg-light">
                <button id="btn-doctors" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-person"></i> Doctors
                </button>
                <button id="btn-add-admin" class="btn btn-success w-100 mb-3">
                    <i class="bi bi-person-plus"></i> Add Admin
                </button>
                <button id="btn-add-doctor" class="btn btn-success w-100 mb-3">
                    <i class="bi bi-person-plus"></i> Add Doctor
                </button>
                <button id="btn-logout" class="btn btn-danger w-100 mb-3">
                    <i class="bi bi-person-plus"></i> Logout
                </button>
            </div>

            <!-- Right Section: Content (Appointments by default) -->
            <div class="right-section">
                <h4>Today's Appointments</h4>
                <div id="appointments-list">
                    <!-- Appointments will be populated here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Doctor Update Modal -->
    <div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="doctorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doctorModalLabel">Update Doctor Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="update-doctor-form">
                        <input type="hidden" id="doctor-id">
                        <div class="mb-3">
                            <label for="doctor-profile-image" class="form-label">Profile Image URL</label>
                            <input type="text" class="form-control" id="doctor-profile-image">
                        </div>
                        <div class="mb-3">
                            <label for="doctor-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="doctor-name">
                        </div>
                        <div class="mb-3">
                            <label for="doctor-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="doctor-email">
                        </div>
                        <div class="mb-3">
                            <label for="doctor-phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="doctor-phone">
                        </div>
                        <div class="mb-3">
                            <label for="doctor-department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="doctor-department">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS & dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
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

        // Function to get the authentication token from localStorage
        function getAuthToken() {
            return localStorage.getItem('token');
        }

        // Function to set Authorization header for fetch requests
        function setAuthHeaders(headers) {
            const token = getAuthToken();
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            return headers;
        }

        // Load dashboard data (appointments count and doctors count)
        function loadDashboardInfo() {
            fetch('http://localhost:8000/api/dashboard', {
                headers: setAuthHeaders({})
            })
            .then(response => response.json())
            .then(data => {
                // console.log('Dashboard data:', data); // Debugging line
                // Update this part based on the actual data structure
                if (data && typeof data === 'object') {
                    document.getElementById('appointments-count').textContent = data.total_appointments || 0;
                    document.getElementById('doctors-count').textContent = data.doctors || 0;
                } else {
                    // console.error('Unexpected data format for dashboard:', data);
                    alert('Something went wrong');
                }
            })
            .catch(error => alert('Error fetching dashboard data:', error));
            
        }

        // Load today's appointments
        function loadAppointments() {
            fetch('http://localhost:8000/api/appointments', {
                headers: setAuthHeaders({})
            })
            .then(response => response.json())
            .then(appointments => {
                // console.log('Appointments data:', appointments.appointments);
                // Update this part based on the actual data structure
                if (Array.isArray(appointments.appointments)) {
                    // console.log("Inside Array")
                    const appointmentsList = document.getElementById('appointments-list');
                    appointmentsList.innerHTML = '';  // Clear previous content
                    appointments.appointments.forEach(appointment => {
                        const row = `<div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">${appointment.patient_name}</h5>
                                            <p class="card-text">${appointment.details}</p>
                                            <p><strong>Date:</strong> ${appointment.booking_date}</p>
                                            <p><strong>City:</strong> ${appointment.city}</p>
                                            <p><strong>Gender:</strong> ${appointment.gender}</p>
                                            <p><strong>Contact Number:</strong> ${appointment.phone_number}</p>
                                            <div class="mb-3">
                                                <label for="status-${appointment.id}" class="form-label"><strong>Status:</strong></label>
                                                <select id="status-${appointment.id}" class="form-select" onchange="updateAppointmentStatus(${appointment.id}, this.value)">
                                                    <option value="pending" ${appointment.appointment_status === 'pending' ? 'selected' : ''}>Pending</option>
                                                    <option value="confirmed" ${appointment.appointment_status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                                    <option value="cancelled" ${appointment.appointment_status === 'cancelled' ? 'selected' : ''}>Canceled</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>`;
                        appointmentsList.innerHTML += row;
                    });
                } else {
                    // console.error('Unexpected data format for appointments:', appointments);
                    alert('Something went wrong');
                }
            })
            .catch(error => alert('Error fetching appointments:', error));
            
        }

        // Function to update the appointment status
        function updateAppointmentStatus(appointmentId, status) {
            // console.log("Appointment Status", status)
            fetch(`http://localhost:8000/api/appointments/${appointmentId}`, {
                method: 'PUT',
                headers: setAuthHeaders({
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }),
                body: JSON.stringify({ appointment_status: status })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Handle success
            //    console.log('Appointment status updated:', data);
                alert('Appointment status updated successfully');
           })
           .catch(error => {
               // Handle error
            //    console.error('Error updating appointment status:', error);
               alert('Failed to update appointment status');
           });
        }

        // Load all doctors when "Doctors" button is clicked
        document.getElementById('btn-doctors').addEventListener('click', function () {
            fetch('http://localhost:8000/api/doctors', {
                headers: setAuthHeaders({})
            })
            .then(response => response.json())
            .then(doctors => {
                // console.log('Doctors data:', doctors.doctors); // Debugging line
                const rightSection = document.querySelector('.right-section');
                rightSection.innerHTML = '<h4>Doctors List</h4>';
                const cardContainer = document.createElement('div');
                cardContainer.classList.add('card-container');

                if (Array.isArray(doctors.doctors)) {
                    // console.log("log 01")
                    doctors.doctors.forEach(doctor => {
                        const card = `
                        <div class="card doctor-card">
                            <div class="card-body">
                                <img src="${doctor.profile_image}" alt="Profile" class="img-thumbnail mb-3">
                                <h5 class="card-title">${doctor.name}</h5>
                                <p class="card-text"><strong>Email:</strong> ${doctor.email}</p>
                                <p><strong>Phone:</strong> ${doctor.phone_number}</p>
                                <p><strong>Department:</strong> ${doctor.department}</p>
                                <button class="btn btn-warning btn-sm" onclick="openUpdateModal(${doctor.id})">Update</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteDoctor(${doctor.id})">Delete</button>
                            </div>
                        </div>`;
                        cardContainer.innerHTML += card;
                    });
                    rightSection.appendChild(cardContainer);
                } else {
                    // console.error('Unexpected data format for doctors:', doctors);
                    alert('Somethings went wrong');
                }
            })
            .catch(error => alert('Error fetching doctors:', error));
            
        });

        // Delete doctor function
        function deleteDoctor(id) {
            if (confirm('Are you sure you want to delete this doctor?')) {
                fetch(`http://localhost:8000/api/doctors/${id}`, {
                    method: 'DELETE',
                    headers: setAuthHeaders({})
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error deleting doctor');
                    alert('Doctor deleted successfully');
                    loadDashboardInfo();  // Reload the dashboard info to update count
                    document.getElementById('btn-doctors').click();  // Reload the doctors list
                })
                .catch(error => alert('Error deleting doctor:', error));
            }
        }

        // Open update modal with existing doctor data
        function openUpdateModal(id) {
            fetch(`http://localhost:8000/api/doctor/${id}`, {
                method: 'GET',
                headers: setAuthHeaders({})
            })
            .then(response => response.json())
            .then(doctor => {
                // console.log("Single Doctor", doctor.doctor)
                document.getElementById('doctor-id').value = doctor.doctor.id;
                document.getElementById('doctor-profile-image').value = doctor.doctorprofile_image;
                document.getElementById('doctor-name').value = doctor.doctor.name;
                document.getElementById('doctor-email').value = doctor.doctor.email;
                document.getElementById('doctor-phone').value = doctor.doctor.phone_number;
                document.getElementById('doctor-department').value = doctor.doctor.department;
                const doctorModal = new bootstrap.Modal(document.getElementById('doctorModal'));
                doctorModal.show();
            })
            .catch(error => alert('Error fetching doctor details:', error));
            
        }

        // Update doctor info
        document.getElementById('update-doctor-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('doctor-id').value;
            // console.log('Id', id)
            const updatedData = {
                profile_image: document.getElementById('doctor-profile-image').value,
                name: document.getElementById('doctor-name').value,
                email: document.getElementById('doctor-email').value,
                phone_number: document.getElementById('doctor-phone').value,
                department: document.getElementById('doctor-department').value,
            };

            fetch(`http://localhost:8000/api/doctors/${id}`, {
                method: 'PUT',
                headers: setAuthHeaders({
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }),
                body: JSON.stringify(updatedData)
            })
            .then(response => response.json())
            .then(data => {
                // console.log('Updated Data',data)
                alert('Doctor updated successfully');
                loadDashboardInfo();
                document.getElementById('btn-doctors').click();  // Reload doctors list
                const doctorModal = bootstrap.Modal.getInstance(document.getElementById('doctorModal'));
                doctorModal.hide();  // Close modal
            })
            .catch(error => alert('Error updating doctor:', error));
        });

        // Navigate to registration form when "Add Admin" button is clicked
        document.getElementById('btn-add-admin').addEventListener('click', function () {
            window.location.href = 'regitration';
        });

        // Navigate to addDoctor form when "Add Doctor" button is clicked
        document.getElementById('btn-add-doctor').addEventListener('click', function () {
            window.location.href = 'addDoctor';
        });

        //Logout User
        document.getElementById('btn-logout').addEventListener('click', async function() {
            // Get token from localStorage
            let token = localStorage.getItem('token');

            try {
                let response = await fetch('http://localhost:8000/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    // Remove the token from localStorage after successful logout
                    localStorage.removeItem('token');
                    localStorage.removeItem('token_type');
                    alert('Logout successful!');
                    window.location.href = 'login'; // Redirect to login or homepage after logout
                } else {
                    alert('Failed to logout. Please try again.');
                }
            } catch (error) {
                // console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            }
        });

        // Initial load
        loadDashboardInfo();
        loadAppointments();
    </script>
</body>
</html>
