<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentBooked extends Mailable
{
    use Queueable, SerializesModels;

    public $patientName;
    public $doctor;
    public $bookingDate;

    public function __construct($patientName, $doctor, $bookingDate)
    {
        $this->patientName = $patientName;
        $this->doctor = $doctor;
        $this->bookingDate = $bookingDate;
    }

    public function build()
    {
        return $this->subject('Appointment Confirmation')
            ->view('emails.appointment_booked');
    }
}
