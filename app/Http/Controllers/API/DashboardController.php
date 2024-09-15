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

        if (!$doctors) {
            return response()->json(['message' => 'No any doctor registered'], 404);
        }

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

    //Update doctor details
    // public function updateDoctor(Request $request, $id)
    // {
    //     // Find the doctor by ID
    //     $doctor = Doctor::find($id);

    //     if (!$doctor) {
    //         return response()->json(['message' => 'Doctor not found'], 404);
    //     }

    //     // Validate the incoming request
    //     $validator = Validator::make($request->all(), [
    //         'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    //         'name' => 'required|string|max:255', // Name is required to be updated
    //         'email' => 'required|email|unique:doctors,email,' . $doctor->id,
    //         'phone_number' => 'required|string|max:15',
    //         'department' => 'required|string|max:255',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     // Handle profile image upload (keep old one if not provided)
    //     if ($request->hasFile('profile_image')) {
    //         // Store the new image and update the path
    //         $imagePath = $request->file('profile_image')->store('images/doctors', 'public');
    //         $doctor->profile_image = $imagePath;
    //     }

    //     // Update the doctor's details explicitly with new values from the request
    //     $doctor->name = $request->input('name');
    //     $doctor->email = $request->input('email');
    //     $doctor->phone_number = $request->input('phone_number');
    //     $doctor->department = $request->input('department');

    //     // Save the updated doctor details
    //     $doctor->save();

    //     return response()->json(['message' => 'Doctor updated successfully', 'doctor' => $doctor], 200);
    // }



    public function updateDoctor(Request $request, $id)
    {
        // Find the doctor by ID
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found',], 404);
        }

        return response()->json([
            'received_data' => $request->all(),
            'files' => $request->file(), // Check if any file is being received
        ], 200);

        // Validate the incoming request for both form-data and JSON
        $validator = Validator::make($request->all(), [
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone_number' => 'required|string|max:15',
            'department' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
                'input_data' => $request->all(),
            ], 422);
        }


        // Handle profile image upload (keep old one if not provided)
        if ($request->hasFile('profile_image')) {
            // Store the new image and update the path
            $imagePath = $request->file('profile_image')->store('images/doctors', 'public');
            $doctor->profile_image = $imagePath;
        }

        // Update the doctor's details explicitly with new values from the request
        $doctor->name = $request->input('name');
        $doctor->email = $request->input('email');
        $doctor->phone_number = $request->input('phone_number');
        $doctor->department = $request->input('department');

        // Save the updated doctor details
        $doctor->save();

        return response()->json(['message' => 'Doctor updated successfully', 'doctor' => $doctor], 200);
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
