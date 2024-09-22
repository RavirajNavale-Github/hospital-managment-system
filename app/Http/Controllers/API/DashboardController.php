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
        $totalDoctors = Doctor::all()->count();

        return response()->json([
            'total_appointments' => $totalAppointments,
            'doctors' => $totalDoctors,
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

    //Get all doctors
    public function getDoctors()
    {
        $doctors = Doctor::all();

        if ($doctors->isEmpty()) {
            return response()->json(['message' => 'No any doctor registered'], 404);
        }

        $doctors->transform(function ($doctor) {
            if ($doctor->profile_image) {
                $doctor->profile_image = url('storage/' . $doctor->profile_image);
            }
            return $doctor;
        });

        return response()->json(['message' => 'All Doctors', 'doctors' => $doctors]);
    }


    //Get single doctor
    public function getDoctor(Request $request, $id)
    {
        // Find the doctor by ID
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        return response()->json(['message' => 'Selected single doctor', 'doctor' => $doctor]);
    }

    public function updateDoctor(Request $request, $id)
    {
        // Find the doctor by ID
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        // Validate the incoming data
        $validatedData = $request->validate([
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Optional file input validation
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id, // Ignore unique check for current doctor
            'phone_number' => 'required|string|max:15',
            'department' => 'required|string|max:255',
        ]);

        // Check if a new profile image is uploaded
        if ($request->hasFile('profile_image')) {
            // Store the new profile image
            $imagePath = $request->file('profile_image')->store('images/doctors', 'public');
            $doctor->profile_image = $imagePath;
        }

        // If no new profile image is uploaded, the existing one remains unchanged

        // Update other fields
        $doctor->name = $validatedData['name'];
        $doctor->email = $validatedData['email'];
        $doctor->phone_number = $validatedData['phone_number'];
        $doctor->department = $validatedData['department'];

        // Save the updated doctor record
        $doctor->save();

        return response()->json(['message' => 'Doctor updated successfully', 'doctor' => $doctor]);
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
