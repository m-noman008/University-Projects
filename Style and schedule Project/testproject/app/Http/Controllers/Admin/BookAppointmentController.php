<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Models\BookAppointment;
use App\Models\Plan;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookAppointmentController extends Controller
{
    use Notify;

    public function appointmentList($status = null)
    {
        $statusMap = [
            'pending' => 0,
            'confirm' => 1,
            'cancel' => 2,
            'done' => 3,
        ];

        $data['book_appointment'] = BookAppointment::with('service.serviceDetails', 'user', 'plan')
            ->when(isset($statusMap[$status]), function ($query) use ($statusMap, $status) {
                return $query->where("status", $statusMap[$status]);
            })
            ->latest()
            ->paginate(config('basic.paginate'));

        $data['countAllAppointment'] = BookAppointment::count();
        $data['countPendingAppointment'] = BookAppointment::where('status', 0)->count();
        $data['countConfirmAppointment'] = BookAppointment::where('status', 1)->count();
        $data['countCancelAppointment'] = BookAppointment::where('status', 2)->count();
        $data['countDoneAppointment'] = BookAppointment::where('status', 3)->count();
        $data['services'] = Service::with('serviceDetails')->latest()->get();
        // Fetch only the appointment times for existing appointments to ensure $data['time'] is always a collection
        $data['time'] = BookAppointment::pluck('appointment_time')->filter()->values();
        $data['plans'] = Plan::where('status', 1)->get();

        return view('admin.book_appointment.appointment_list', $data);
    }


    public function editAppointment($id)
    {
        $data['appointment_info'] = BookAppointment::with('service', 'user')->findOrFail($id);

        $data['servicesName'] = Service::with('serviceDetails')->latest()->get();
        return view('admin.book_appointment.edit_appointment', $data);
    }

    public function deleteAppointment(Request $request, $id)
    {
        $appointment_info = BookAppointment::findOrFail($id);
        $appointment_info->delete();
        return back()->with('success', 'Book Appointment Deleted Successfully');
    }

    public function updateAppointment(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'nullable|integer',
            'full_name' => 'required|max:50',
            'email' => 'required|max:50|email',
            'phone' => 'required|max:50',
            'date_of_appointment' => 'required|date',
            'appointment_time' => 'required',
            'message' => 'required|max:1000',
        ]);

        $book_appointment = BookAppointment::with('plan')->findOrFail($id);
        $book_appointment->service_id = $request->service_name;
        $book_appointment->full_name = $request->full_name;
        $book_appointment->email = $request->email;
        $book_appointment->phone = $request->phone;
        $book_appointment->date_of_appointment = $request->date_of_appointment;
        $book_appointment->appointment_time = $request->appointment_time;
        $book_appointment->message = $request->message;
        if ($request->isConfirm == 1) {
            $book_appointment->status = $request->isConfirm;
            $book_appointment->save();

            $msg = [
                'service' => $request->service_name ? optional($book_appointment->service->serviceDetails)->service_name : optional($book_appointment->plan)->name . " plan services",
                'date' => dateTime($book_appointment->date_of_appointment, 'd M Y'),
                'time' => timeFormat($book_appointment->appointment_time),
            ];

            $action = [
                "link" => route('user.my.appointment'),
                "icon" => "fa-light fa-calendar-check"
            ];

            $this->userPushNotification($book_appointment->user, 'APPOINTMENT_CONFIRM ', $msg, $action);
            $this->sendMailSms($book_appointment->user, 'APPOINTMENT_CONFIRM', [
                'service' => $request->service_name ? optional($book_appointment->service->serviceDetails)->service_name : optional($book_appointment->plan)->name . " plan services",
                'date' => $book_appointment->date_of_appointment,
                'time' => $book_appointment->appointment_time,
                'message' => $book_appointment->message,
            ]);
        }

        if ($request->isCancel == 2) {
            $book_appointment->status = $request->isCancel;
            $book_appointment->save();

            $msg = [
                'service' => $request->service_name ? optional($book_appointment->service->serviceDetails)->service_name : optional($book_appointment->plan)->name . " plan services",
                'date' => dateTime($book_appointment->date_of_appointment, 'd M Y'),
            ];

            $action = [
                "link" => route('user.my.appointment'),
                "icon" => "fa-light fa-calendar-check"
            ];
            $this->userPushNotification($book_appointment->user, 'APPOINTMENT_CANCEL ', $msg, $action);
            $this->sendMailSms($book_appointment->user, 'APPOINTMENT_CANCEL', [
                'service' => $request->service_name ? optional($book_appointment->service->serviceDetails)->service_name : optional($book_appointment->plan)->name . " plan services",
                'date' => dateTime($book_appointment->date_of_appointment, 'd M Y'),
                'message' => $book_appointment->message,
            ]);
        }
        if ($request->isDone == 3) {
            $book_appointment->status = $request->isDone;
            $book_appointment->save();

            $msg = [
                'service' => $request->service_name ? optional($book_appointment->service->serviceDetails)->service_name : optional($book_appointment->plan)->name . " plan services",
                'date' => dateTime($book_appointment->date_of_appointment, 'd M Y'),
            ];

            $action = [
                "link" => route('user.my.appointment'),
                "icon" => "fa-light fa-calendar-check"
            ];
            $this->userPushNotification($book_appointment->user, 'APPOINTMENT_DONE ', $msg, $action);
            $this->sendMailSms($book_appointment->user, 'APPOINTMENT_DONE', [
                'service' => $request->service_name ? optional($book_appointment->service->serviceDetails)->service_name : optional($book_appointment->plan)->name . " plan services",
                'date' => dateTime($book_appointment->date_of_appointment, 'd M Y'),
                'message' => $book_appointment->message,
            ]);
        }

        $book_appointment->save();
        return back()->with('success', 'Update Appointment Information.');
    }


    public function confirmAppointment(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Appointment List.');
            return response()->json(['error' => 1]);
        } else {
            BookAppointment::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            session()->flash('success', 'Appointment is confirm');
            return response()->json(['success' => 1]);
        }
    }

    public function cancelAppointment(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Appointment List.');
            return response()->json(['error' => 1]);
        } else {
            BookAppointment::whereIn('id', $request->strIds)->update([
                'status' => 2,
            ]);
            session()->flash('success', 'Appointment Cancel');
            return response()->json(['success' => 1]);
        }
    }

    public function doneAppointment(Request $request)
    {
        if ($request->strIds == null) {
            $this->error('Please select appointment list.');
            return back();
        } else {
            $ids = explode(',', $request->strIds);

            BookAppointment::whereIn('id', $ids)->update([
                'status' => 3,
            ]);

            session()->flash('success', 'Appointment Done');

            $this->success('Appointment status updated successfully.');
            return back();
        }
    }


    public function searchAppointment(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $book_appointment = BookAppointment::with('service', 'plan')->orderBy('id', 'DESC')
            ->when(isset($search['service_id']), function ($query) use ($search) {
                return $query->whereHas('service', function ($q) use ($search) {
                    $q->where('id', 'LIKE', "%{$search['service_id']}%");
                });
            })
            ->when(isset($search['plan_id']), function ($query) use ($search) {
                return $query->whereHas('plan', function ($q) use ($search) {
                    $q->where('id', 'LIKE', "%{$search['plan_id']}%");
                });
            })
            ->when(isset($search['full_name']), function ($query) use ($search) {
                $query->where('full_name', 'LIKE', "%{$search['full_name']}%");
            })
            ->when(isset($search['email']), function ($query) use ($search) {
                $query->where('email', 'LIKE', "%{$search['email']}%");
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("date_of_appointment", $dateSearch);
            })
            ->paginate(config('basic.paginate'));
        $book_appointment = $book_appointment->appends($search);

        $data['countAllAppointment'] = BookAppointment::count();
        $data['countPendingAppointment'] = BookAppointment::where('status', 0)->count();
        $data['countConfirmAppointment'] = BookAppointment::where('status', 1)->count();
        $data['countCancelAppointment'] = BookAppointment::where('status', 2)->count();
        $data['countDoneAppointment'] = BookAppointment::where('status', 3)->count();
        $data['services'] = Service::with('serviceDetails')->latest()->get();
        $data['plans'] = Plan::where('status', 1)->get();

        return view('admin.book_appointment.appointment_list', $data, compact('book_appointment'));
    }

    public function updateTime(Request $request, $id)
    {
        $request->validate([
            'appointment_time' => 'required'
        ]);

        $book_appointment = BookAppointment::findOrFail($id);
        $book_appointment->appointment_time = $request->appointment_time;
        $book_appointment->save();
        return back()->with('success', 'Updated Appointment Time Successfully!');

    }
}
