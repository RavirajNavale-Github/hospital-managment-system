<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function bookAppointment(Request $request)
    {
        // Define validation rules
        $rules = [
            'patient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email',
            'booking_date' => 'required|date',
            'city' => 'required|string|max:255',
            'speciality' => 'required|string|max:255',
            'doctor' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'age' => 'required|integer|min:0',
            'details' => 'nullable|string',
        ];

        // Validate the request data using Validator::make()
        $validatedData = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validatedData->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validatedData->errors(),
            ], 401);
        }

        // If validation passes, create the appointment
        $appointment = Appointment::create($request->all());

        //return success message
        return response()->json([
            'message' => 'Appointment booked successfully!',
            'appointment' => $appointment
        ], 201);
    }
}
