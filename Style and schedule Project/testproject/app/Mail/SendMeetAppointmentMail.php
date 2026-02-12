<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMeetAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $book_appointment;
    public $service_name;

    public function __construct($book_appointment, $service_name)
    {
        $this->theme = template();
        $this->bookAppointment = $book_appointment;
        $this->service_name = $service_name;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailMessage = $this->subject("Appointment Confirmation Mail")
            ->from(optional($this->bookAppointment)->email, optional($this->bookAppointment)->full_name)
            ->view('admin.mail.meet_appointment', [
                'bookAppointment' => $this->bookAppointment,
                'service_name' => $this->service_name,
            ]);
    }
}
