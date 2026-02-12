<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PlanPurchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyPlanController extends Controller
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

    public function myPlan()
    {
        $user = Auth::user();
        $data['plans'] = Plan::where('status', 1)->latest()->get();
        $data['myPlanPurchase'] = PlanPurchase::with('plans','bookAppointment')
            ->where('user_id', $user->id)
            ->paginate(10);
        return view($this->theme . 'user.my_plan', $data);
    }

    public function searchPlan(Request $request)
    {

        $search = $request->all();
        $purchaseDate = $request->purchase_date;
        $expireDate = $request->expire_date;

        $purchaseDateSearch = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $purchaseDate);
        $expireDateSearch = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $expireDate);

        $myPlanPurchase = PlanPurchase::where('user_id', $this->user->id)->with('plans')
            ->when(isset($search['plan_id']), function ($query) use ($search) {
                $query->whereHas('plans', function ($qq) use ($search) {
                    return $qq->where('id', 'like', "%{$search['plan_id']}%");
                });
            })
            ->when($purchaseDateSearch == 1, function ($query) use ($purchaseDate) {
                return $query->whereDate("purchase_date", $purchaseDate);
            })
            ->when($expireDateSearch == 1, function ($query) use ($expireDate) {
                return $query->whereDate("purchase_date", $expireDate);
            })
            ->paginate(10);

        $myPlanPurchase = $myPlanPurchase->appends($search);

        $data['plans'] = Plan::where('status', 1)->latest()->get();

        return view($this->theme . 'user.my_plan', $data, compact('myPlanPurchase'));
    }
}
