<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderPaymentController extends Controller
{
    public function orderPaymentCheck(Request $request)
    {
        $paymentId = $request->paymentId;
        $data['paymentGatewayInfo'] = Gateway::findOrFail($paymentId);
        return response()->json(['data' => $data]);
    }

    public function productPlaceOrder(Request $request)
    {

        $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'phone' => 'required|max:50',
            'email' => 'required|email|max:50',
            'company_name' => 'nullable|max:50',
            'street_address' => 'required|max:200',
        ]);


        $cartItem = json_decode($request->cartItem);

        if (!$cartItem) {
            return back()->with('error', 'Please select product to purchase!');
        }

        foreach ($cartItem as $item) {
            $stock = ProductStock::where('product_id', $item->id)
                ->when(isset($item->attributes), function ($query) use ($item){
                    if ($item->attributes){
                        $query->whereJsonContains('attributes_id', $item->attributes);
                    }
                })
            ->first();
            if ($item->count > $stock->qty) {
                return back()->with('warning', 'Out of stock!');
            }
        }


        if ($request->payment_method == 'Cash On Delivery'){
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->order_number = mt_rand(10000000, 99999999);
            $order->payment_type = $request->payment_method ?? 'Pay Online';
            $order->gateway_id = $gate->id ?? null;
            $order->shipping = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'company_name' => $request->company_name,
                'street_address' => $request->street_address,
            ];

            $order->save();


            foreach ($cartItem as $item) {
                $orderDetails = new OrderDetails();
                $orderDetails->order_id = $order->id;
                $orderDetails->product_id = $item->id;
                $orderDetails->attributes_id = $item->attributes ?? null;
                $orderDetails->qty = $item->count;
                $orderDetails->price = $item->price;
                $orderDetails->total_price = $item->price * $item->count;
                $orderDetails->save();
            }

            foreach ($cartItem as $singleProduct) {
                $stock = ProductStock::where('product_id', $singleProduct->id)
                    ->when(isset($singleProduct->attributes), function ($query) use ($singleProduct){
                        if ($singleProduct->attributes){
                            $query->whereJsonContains('attributes_id', $singleProduct->attributes);
                        }
                    })
                    ->first();
                $newStock = $stock->qty - $singleProduct->quantity;
                $stock->update(['qty' => $newStock]);
            }

            return redirect()->route('user.order.confirm', [$order->id])->with('success', 'Thank you. Your Order Has Been Received');

        }else{

            if ($request->gateway) {
                $gate = Gateway::whereStatus(1)->findOrFail($request->gateway);
            }

            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->order_number = mt_rand(10000000, 99999999);
            $order->payment_type = $request->payment_method ?? 'Pay Online';
            $order->gateway_id = $gate->id ?? null;
            $order->shipping = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'company_name' => $request->company_name,
                'street_address' => $request->street_address,
            ];
            $order->save();

            $totalPrice =0;
            foreach ($cartItem as $item) {
                $orderDetails = new OrderDetails();
                $orderDetails->order_id = $order->id;
                $orderDetails->product_id = $item->id;
                $orderDetails->attributes_id = $item->attributes ?? null;
                $orderDetails->qty = $item->count;
                $orderDetails->price = $item->price;
                $orderDetails->total_price = $item->price * $item->count;
                $orderDetails->save();
                $totalPrice = $totalPrice+$orderDetails->total_price;
            }

            $user = Auth::user();
            $gate = Gateway::whereStatus(1)->findOrFail($request->gateway);

            if ($request->gateway) {
                $reqAmount = $totalPrice;
                $charge = getAmount($gate->fixed_charge + ($reqAmount * $gate->percentage_charge / 100));
                $payable = getAmount($reqAmount + $charge);
                $final_amo = getAmount($payable * $gate->convention_rate);
                $fund = PaymentController::newFund($request, $user, $gate, $charge, $final_amo, $reqAmount, null,$order->id);

                foreach ($cartItem as $singleProduct) {
                    $stock = ProductStock::where('product_id', $singleProduct->id)
                        ->when(isset($singleProduct->attributes), function ($query) use ($singleProduct){
                            if ($singleProduct->attributes){
                                $query->whereJsonContains('attributes_id', $singleProduct->attributes);
                            }
                        })
                        ->first();
                    $newStock = $stock->qty - $singleProduct->quantity;
                    $stock->update(['qty' => $newStock]);
                }

                session()->put('order', 'product_order');
                session()->put('order_id', $order->id);
                session()->put('track', $fund['transaction']);
                return redirect()->route('user.addFund.confirm');


            }
        }


    }


}
