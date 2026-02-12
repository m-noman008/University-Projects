<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\BookAppointment;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\Plan;
use App\Models\PlanPurchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanPurchaseController extends Controller
{
    public function __construct()
    {
        $this->theme = template();

    }

    public function planPurchase($id)
    {
        $data['gateways'] = Gateway::where('status', 1)->get();
        return view($this->theme . 'plan_purchase', $data, compact('id'));
    }


    public function getPaymentInfo(Request $request)
    {
        $planId = $request->planId;
        $paymentId = $request->paymentId;
        $data['planInfo'] = Plan::findOrFail($planId);
        $data['paymentGatewayInfo'] = Gateway::findOrFail($paymentId);
        return response()->json(['data' => $data]);
    }

    public function planPayment(Request $request)
    {
        $user = Auth::user();
        $plan = Plan::findOrFail($request->plan_id);
        $planPurchase = new PlanPurchase();
        $planPurchase->user_id = $user->id;
        $planPurchase->plan_id = $request->plan_id;
        $planPurchase->purchase_date = Carbon::now();
        $planPurchase->save();

        BookAppointment::create([
            'user_id' => $user->id,
            'plan_id' => $request->plan_id,
        ]);

        $gate = Gateway::where('status', 1)->findOrFail($request->gateway);
        $reqAmount = $plan->price;
        $charge = getAmount($gate->fixed_charge + ($reqAmount * $gate->percentage_charge / 100));
        $payable = getAmount($reqAmount + $charge);
        $final_amo = getAmount($payable * $gate->convention_rate);
        $fund = PaymentController::newFund($request, $user, $gate, $charge, $final_amo, $reqAmount, $planPurchase->id);

        session()->put('plan', 'plan_data');
        session()->put('track', $fund['transaction']);

        return redirect()->route('user.addFund.confirm');

    }

}
