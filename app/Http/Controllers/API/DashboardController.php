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
}
