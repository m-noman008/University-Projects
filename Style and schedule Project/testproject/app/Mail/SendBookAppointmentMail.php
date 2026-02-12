<?php

namespace App\Mail;

use App\Models\BookAppointment;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendBookAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $bookAppointment;
    public $service_name;

    public function __construct($bookAppointment, $service_name)
    {
        $this->theme = template();
        $this->bookAppointment = $bookAppointment;
        $this->service_name = $service_name;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailMessage = $this->subject("Send Appointment Request")
            ->from(optional($this->bookAppointment)->email, optional($this->bookAppointment)->full_name)
            ->view($this->theme . 'mail.book_appointment', [
                'bookAppointment' => $this->bookAppointment,
                'service_name' => $this->service_name,
            ]);
    }
}
