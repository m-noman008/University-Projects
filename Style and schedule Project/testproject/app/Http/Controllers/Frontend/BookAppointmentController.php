<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Mail\SendBookAppointmentMail;
use App\Models\BookAppointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookAppointmentController extends Controller
{
    use Notify;

    // public function bookAppointmentStore(Request $request)
    // {
    //     if (!Auth::check()) {
    //         return back()->withErrors(['You must be logged in to book an appointment.']);
    //     }

    //     $user = Auth::user();

    //     $request->validate([
    //         'service_name' => 'required',
    //         'date_of_appointment' => 'required',
    //         'message' => 'required',
    //     ]);

    //     $bookAppointment = new BookAppointment();
    //     $bookAppointment->user_id = $user->id;
    //     $bookAppointment->full_name = $user->full_name;
    //     $bookAppointment->email = $user->email;
    //     $bookAppointment->phone = $user->phone;
    //     $bookAppointment->service_id = $request->service_name;
    //     $bookAppointment->date_of_appointment = $request->date_of_appointment;
    //     $bookAppointment->message = $request->message;
    //     $bookAppointment->save();

    //     $service_name = Service::with('serviceDetails')->where('id', $bookAppointment->service_id)->first();

    //     $msg = [
    //         'username' => $user->username,
    //         'service' => optional($bookAppointment->service->serviceDetails)->service_name ?? 'abc',
    //         'date' => $bookAppointment->date_of_appointment,
    //     ];

    //     $action = [
    //         "link" => route('admin.edit.appointment', $bookAppointment->id),
    //         "icon" => "fa fa-money-bill-alt text-white"
    //     ];
    //     $this->adminPushNotification('BOOK_APPOINTMENT ', $msg, $action);
    //     return back()->with('success', 'Appointment request sent successfully');
    // }

    public function bookAppointmentStore(Request $request)
    {
        if (!Auth::check()) {
            return back()->withErrors(['You must be logged in to book an appointment.']);
        }

        $user = Auth::user();

        $request->validate([
            'service_name' => 'required',
            'date_of_appointment' => 'required',
            'message' => 'required',
        ]);

        $bookAppointment = new BookAppointment();
        $bookAppointment->user_id = $user->id;
        $bookAppointment->full_name = $user->full_name;
        $bookAppointment->email = $user->email;
        $bookAppointment->phone = $user->phone;
        $bookAppointment->service_id = $request->service_name;
        $bookAppointment->date_of_appointment = $request->date_of_appointment;
        $bookAppointment->message = $request->message;
        $bookAppointment->save();

        $service_name = Service::with('serviceDetails')->where('id', $bookAppointment->service_id)->first();

        $msg = [
            'username' => $user->username,
            'service' => optional($bookAppointment->service->serviceDetails)->service_name ?? 'abc',
            'date' => $bookAppointment->date_of_appointment,
        ];

        $action = [
            "link" => route('admin.edit.appointment', $bookAppointment->id),
            "icon" => "fa fa-money-bill-alt text-white"
        ];
        $this->adminPushNotification('BOOK_APPOINTMENT ', $msg, $action);
        return back()->with('success', 'Appointment request sent successfully');
    }
}
