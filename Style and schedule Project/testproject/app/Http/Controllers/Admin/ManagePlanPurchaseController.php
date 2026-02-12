<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanPurchase;
use Illuminate\Http\Request;

class ManagePlanPurchaseController extends Controller
{
    public function planSoldList()
    {
        $data['plan_sold'] = PlanPurchase::with('plans', 'users', 'bookAppointment', 'funds')->orderBy('id', 'DESC')
            ->whereHas('funds', function ($query) {
                $query->where('status', 1);
            })
            ->paginate(config('basic.paginate'));
        $data['plans'] = Plan::where('status', 1)->get();
        return view('admin.plan_sold.plan_list', $data);
    }

    public function searchPlanSoldList(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $plan_sold = PlanPurchase::with('plans', 'users')->orderBy('id', 'DESC')
            ->when(isset($search['plan_id']), function ($query) use ($search) {
                return $query->whereHas('plans', function ($q) use ($search) {
                    $q->where('id', 'LIKE', "%{$search['plan_id']}%");
                });
            })
            ->when(isset($search['user_name']), function ($query) use ($search) {
                return $query->whereHas('users', function ($q) use ($search) {
                    $q->where('username', 'LIKE', "%{$search['user_name']}%");
                });
            })
            ->when(isset($search['email']), function ($query) use ($search) {
                return $query->whereHas('users', function ($q) use ($search) {
                    $q->where('email', 'LIKE', "%{$search['email']}%");
                });
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                $query->whereDate("purchase_date", $dateSearch);
                $query->orWhereDate("expire_date", $dateSearch);
            })
            ->whereHas('funds', function ($query) {
                $query->where('status', 1);
            })
            ->paginate(config('basic.paginate'));

        $plan_sold = $plan_sold->appends($search);
        $data['plans'] = Plan::where('status', 1)->get();
        return view('admin.plan_sold.plan_list', $data, compact('plan_sold'));
    }


}
