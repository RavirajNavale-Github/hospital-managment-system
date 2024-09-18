<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    background: linear-gradient(45deg, #1155cb, #a6c0fe);
    background-attachment: fixed; /* Ensure the background stays fixed */
    background-size: cover; /* Cover the entire viewport */
    background-repeat: no-repeat; /* Avoid repeating the background image */
    height: 100%;
    margin: 0;
}

.dashboard-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.left-section {
    flex: 1;
    max-width: 250px;
    background: linear-gradient(145deg, #B2EBF2, #EEFCFD);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    height: 270px;
}

.right-section {
    flex: 2;
    background: linear-gradient(145deg, #B2EBF2, #EEFCFD);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
}

.doctor-card {
    display: flex;
    flex-direction: column;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.card-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-body {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-title {
    margin: 0;
}

.btn-custom {
    width: 100%;
    margin-bottom: 10px;
    background: linear-gradient(to left, #007bff, #0056b3);
    border: none;
    color: white;
}

#btn-logout {
    width: 100%;
    margin-bottom: 10px;
    background: linear-gradient(to right, #db1d1d, #ff5c5c);
    border: none;
    color: white;
}

#btn-logout:hover{
    background: linear-gradient(to left, #db1d1d, #ff5c5c);
    color: white;
}

.btn-custom:hover {
    background: linear-gradient(to right, #007bff, #0056b3);
    color: white;
}

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
}
    </style>
</head>
<body>

    <div class="container mt-4">
        <div class="text-center mb-4">
            <h3>Today's Appointments: <span id="appointments-count">0</span></h3>
            <h3>Doctors Registered: <span id="doctors-count">0</span></h3>
        </div>

        <div class="dashboard-container">
            <div class="left-section">
                <button id="btn-doctors" class="btn btn-custom">
                    <i class="bi bi-person"></i> Doctors
                </button>
                <button id="btn-add-admin" class="btn btn-custom">
                    <i class="bi bi-person-plus"></i> Add Admin
                </button>
                <button id="btn-add-doctor" class="btn btn-custom">
                    <i class="bi bi-person-plus"></i> Add Doctor
                </button>
                <button id="btn-logout" class="btn btn-custom">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
                <button id="btn-back" class="btn btn-custom">
                    <i class="bi bi-arrow-left"></i> Go Back
                </button>
            </div>

            <div class="right-section">
                <h4>Today's Appointments</h4>
                <div class="table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Details</th>
                                <th>Date</th>
                                <th>City</th>
                                <th>Gender</th>
                                <th>Contact Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="appointments-list">
                            <!-- Appointments will be populated here -->
                        </tbody>
                    </table>
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
                            <label for="doctor-profile-image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="doctor-profile-image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="doctor-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="doctor-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="doctor-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="doctor-email" required>
                        </div>
                        <div class="mb-3">
                            <label for="doctor-phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="doctor-phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="doctor-department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="doctor-department" required>
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
        function checkAuthentication() {
            const token = localStorage.getItem('token');
            if (!token) {
                window.location.href = 'login';
                alert('Please Login first');
            }
        }

        checkAuthentication();

        function getAuthToken() {
            return localStorage.getItem('token');
        }

        function setAuthHeaders(headers) {
            const token = getAuthToken();
            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            }
            return headers;
        }

        function loadDashboardInfo() {
            fetch('http://localhost:8000/api/dashboard', {
                method: 'GET',
                headers: setAuthHeaders({}),
            })
            .then(response => response.json())
            .then(data => {
                if (data && typeof data === 'object') {
                    document.getElementById('appointments-count').textContent = data.total_appointments || 0;
                    document.getElementById('doctors-count').textContent = data.doctors || 0;
                } else {
                    alert('Something went wrong');
                }
            })
            .catch(error => alert('Error fetching dashboard data: ' + error));
        }

        function loadAppointments() {
            fetch('http://localhost:8000/api/appointments', {
                method: 'GET',
                headers: setAuthHeaders({}),
            })
            .then(response => response.json())
            .then(appointments => {
                if (Array.isArray(appointments.appointments)) {
                    const appointmentsList = document.getElementById('appointments-list');
                    appointmentsList.innerHTML = '';
                    appointments.appointments.forEach(appointment => {
                        const row = `<tr>
                                        <td>${appointment.patient_name}</td>
                                        <td>${appointment.details}</td>
                                        <td>${appointment.booking_date}</td>
                                        <td>${appointment.city}</td>
                                        <td>${appointment.gender}</td>
                                        <td>${appointment.phone_number}</td>
                                        <td>
                                            <select id="status-${appointment.id}" class="form-select" onchange="updateAppointmentStatus(${appointment.id}, this.value)">
                                                <option value="pending" ${appointment.appointment_status === 'pending' ? 'selected' : ''}>Pending</option>
                                                <option value="confirmed" ${appointment.appointment_status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                                <option value="cancelled" ${appointment.appointment_status === 'cancelled' ? 'selected' : ''}>Canceled</option>
                                            </select>
                                        </td>
                                    </tr>`;
                        appointmentsList.innerHTML += row;
                    });
                } else {
                    alert('Something went wrong');
                }
            })
            .catch(error => alert('Error fetching appointments: ' + error));
        }

        function updateAppointmentStatus(appointmentId, status) {
            fetch(`http://localhost:8000/api/appointments/${appointmentId}`, {
                method: 'PUT',
                headers: setAuthHeaders({
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }),
                body: JSON.stringify({ appointment_status: status })
            })
            .then(response => {
                if (!response.ok) throw new Error('Error updating appointment status');
                alert('Appointment status updated successfully');
            })
            .catch(error => alert('Error updating appointment status: ' + error));
        }

        document.getElementById('btn-doctors').addEventListener('click', function () {
            fetch('http://localhost:8000/api/doctors', {
                method: 'GET',
                headers: setAuthHeaders({})
            })
            .then(response => response.json())
            .then(doctors => {
                const rightSection = document.querySelector('.right-section');
                rightSection.innerHTML = '<h4>Doctors List</h4>';
                const cardContainer = document.createElement('div');
                cardContainer.classList.add('card-container');

                if (Array.isArray(doctors.doctors)) {
                    doctors.doctors.forEach(doctor => {
                        const card = `    
                        <div class="card doctor-card">
                            <div class="card-body">
                                <img src="${doctor.profile_image}" width="150px" alt="Profile" class="img-thumbnail mb-3">
                                <h5 class="card-title">${doctor.name}</h5>
                                <p class="card-text"><strong>Email:</strong> ${doctor.email}</p>
                                <p><strong>Phone:</strong> ${doctor.phone_number}</p>
                                <p><strong>Department:</strong> ${doctor.department}</p>
                                <button class="btn btn-warning btn-sm mb-2" onclick="openUpdateModal(${doctor.id})">Update</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteDoctor(${doctor.id})">Delete</button>
                            </div>
                        </div>`;
                        cardContainer.innerHTML += card;
                    });
                    rightSection.appendChild(cardContainer);
                } else {
                    alert('Something went wrong');
                }
            })
            .catch(error => alert('Error fetching doctors: ' + error));
        });

        function deleteDoctor(id) {
            if (confirm('Are you sure you want to delete this doctor?')) {
                fetch(`http://localhost:8000/api/doctors/${id}`, {
                    method: 'DELETE',
                    headers: setAuthHeaders({})
                })
                .then(response => {
                    if (!response.ok) throw new Error('Error deleting doctor');
                    alert('Doctor deleted successfully');
                    loadDashboardInfo();
                    document.getElementById('btn-doctors').click();
                })
                .catch(error => alert('Error deleting doctor: ' + error));
            }
        }

        function openUpdateModal(id) {
            fetch(`http://localhost:8000/api/doctor/${id}`, {
                method: 'GET',
                headers: setAuthHeaders({})
            })
            .then(response => response.json())
            .then(doctor => {
                document.getElementById('doctor-id').value = doctor.doctor.id;
                document.getElementById('doctor-name').value = doctor.doctor.name;
                document.getElementById('doctor-email').value = doctor.doctor.email;
                document.getElementById('doctor-phone').value = doctor.doctor.phone_number;
                document.getElementById('doctor-department').value = doctor.doctor.department;
                const doctorModal = new bootstrap.Modal(document.getElementById('doctorModal'));
                doctorModal.show();
            })
            .catch(error => alert('Error fetching doctor details: ' + error));
        }

        document.getElementById('update-doctor-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('doctor-id').value;
            const profileImage = document.getElementById('doctor-profile-image').files[0];
            const formData = new FormData();
            formData.append('profile_image', profileImage);
            formData.append('name', document.getElementById('doctor-name').value);
            formData.append('email', document.getElementById('doctor-email').value);
            formData.append('phone_number', document.getElementById('doctor-phone').value);
            formData.append('department', document.getElementById('doctor-department').value);

            fetch(`http://localhost:8000/api/doctors/${id}`, {
                method: 'POST',
                headers: setAuthHeaders({ 'Accept': 'application/json' }),
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert('Doctor updated successfully');
                loadDashboardInfo();
                document.getElementById('btn-doctors').click(); 
                const doctorModal = bootstrap.Modal.getInstance(document.getElementById('doctorModal'));
                doctorModal.hide();
            })
            .catch(error => alert('Error updating doctor: ' + error));
        });

        document.getElementById('btn-add-admin').addEventListener('click', function () {
            window.location.href = 'regitration';
        });

        document.getElementById('btn-add-doctor').addEventListener('click', function () {
            window.location.href = 'addDoctor';
        });

        document.getElementById('btn-logout').addEventListener('click', async function() {
            const token = localStorage.getItem('token');
            try {
                let response = await fetch('http://localhost:8000/api/logout', {
                    method: 'POST',
                    headers: setAuthHeaders({
                        'Content-Type': 'application/json'
                    })
                });

                if (response.ok) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('token_type');
                    alert('Logout successful!');
                    window.location.href = 'login';
                } else {
                    alert('Failed to logout. Please try again.');
                }
            } catch (error) {
                alert('An error occurred. Please try again later.');
            }
        });

        document.getElementById('btn-back').addEventListener('click', function () {
            location.reload();
        });

        // Initial load
        loadDashboardInfo();
        loadAppointments();
    </script>
</body>
</html>
