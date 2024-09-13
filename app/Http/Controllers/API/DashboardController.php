<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    //Get total appointments and doctors
    public function dashboard()
    {
        $totalAppointments = Appointment::whereDate('booking_date', now())->count();
        $doctors = Doctor::all();

        return response()->json([
            'total_appointments' => $totalAppointments,
            'doctors' => $doctors,
        ]);
    }

    //View today's appointments
    public function viewAppointments()
    {
        $appointments = Appointment::whereDate('booking_date', now())->get();

        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    //Update appointment status
    public function updateAppointmentStatus(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->update(['appointment_status' => $request->appointment_status]);

        return response()->json(['message' => 'Appointment status updated successfully']);
    }

    //Add new doctor
    public function addDoctor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors',
            'phone_number' => 'required|string|max:15',
            'department' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('images/doctors', 'public');
        } else {
            $imagePath = null;
        }

        $doctor = Doctor::create([
            'profile_image' => $imagePath,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'department' => $request->department,
        ]);

        return response()->json(['message' => 'Doctor added successfully', 'doctor' => $doctor], 201);
    }

    //Update doctor details
    public function updateDoctor(Request $request, $id)
    {
        // Find the doctor by ID
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'profile_image' => 'nullable|url',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $id,
            'phone_number' => 'required|string|max:15',
            'department' => 'required|string|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update the doctor with validated data
        $doctor->update($request->only([
            'profile_image',
            'name',
            'email',
            'phone_number',
            'department'
        ]));

        return response()->json(['message' => 'Doctor details updated successfully']);
    }

    //Delete doctor
    public function deleteDoctor($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        $doctor->delete();

        return response()->json(['message' => 'Doctor deleted successfully']);
    }
}
