<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BookAppointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function myAppointment()
    {
        $user = Auth::user();
        $data['services'] = Service::with('serviceDetails')->latest()->get();
        $data['appointment_list'] = BookAppointment::where('user_id', $user->id)->orderBy('id', 'DESC')->latest()->paginate(10);
        return view($this->theme . 'user.my_appointment', $data);
    }

    public function myAppointmentDateFixed(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date|max:255',
            'time' => 'required',
        ]);

        $user = Auth::user();
        $appointment_list = BookAppointment::where('user_id', $user->id)->findOrFail($id);
        $appointment_list->update([
            'date_of_appointment' => $request->date,
            'appointment_time' => $request->time,
        ]);

        return redirect()->back()->with('success', 'Updated your appointment date.');
    }

    public function searchAppointment(Request $request)
    {

        $search = $request->all();

        $dateSearchFrom = $request->from_date;
        $dateSearchTo = $request->to_date;

        $dateSearchFrom2 = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearchFrom);
        $dateSearchTo2 = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearchTo);

        $appointment_list = BookAppointment::where('user_id', $this->user->id)->with('service')
            ->when(isset($search['service_name']), function ($query) use ($search) {
                $query->whereHas('service', function ($qq) use ($search) {
                    return $qq->where('id', 'like', "%{$search['service_name']}%");
                });
            })
            ->when($dateSearchFrom2 == 1 && $dateSearchTo2 == 1, function ($query) use ($dateSearchFrom, $dateSearchTo) {
                return $query->whereBetween('date_of_appointment', [$dateSearchFrom, $dateSearchTo]);
            })
            ->paginate(10);

        $appointment_list = $appointment_list->appends($search);

        $data['services'] = Service::with('serviceDetails')->latest()->get();

        return view($this->theme . 'user.my_appointment', $data, compact('appointment_list'));
    }
}
