<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
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

    public function myOrder()
    {
        $user = Auth::user();

        $myOrderData = OrderDetails::with('getOrder.gateway', 'getProductInfo')
            ->whereHas('getOrder', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->groupBy('order_id')
            ->get()
            ->each(function ($item) {
                $q = OrderDetails::where('order_id', $item->order_id)->sum('total_price');
                $item['totalAmount'] = $q;

                return $item;
            });

        $myOrderData = paginate($myOrderData, $perPage = 10, $page = null, $options = ["path" => route('user.my.order')]);

        return view($this->theme . 'user.my_order', compact('myOrderData'));
    }

    public function myOrderDetails($id)
    {

        $user = Auth::user();

        $data['my_order_details'] = OrderDetails::with('getOrder', 'getProductInfo')
            ->whereHas('getOrder', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('order_id', $id)->get();

        return view($this->theme . 'user.my_order_details', $data);
    }

    public function orderSearch(Request $request)
{
    // Check if the user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login'); // Redirect to the login page if the user is not authenticated
    }

    $user = Auth::user();

    $search = $request->all();
    $dateSearch = $request->date;
    $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

    $myOrderData = OrderDetails::with('getOrder')
        ->where(function ($query) use ($user) {
            $query->whereHas('getOrder', function ($qq) use ($user) {
                $qq->where('user_id', $user->id);
            });
        })
        ->when(@$search['order_number'], function ($query) use ($search) {
            $query->whereHas('getOrder', function ($qq) use ($search) {
                return $qq->where('order_number', 'LIKE', "%{$search['order_number']}%");
            });
        })
        ->when(@$search['payment_type'], function ($query) use ($search) {
            $query->whereHas('getOrder', function ($qq) use ($search) {
                return $qq->where('payment_type', 'LIKE', "%{$search['payment_type']}%");
            });
            $query->orWhereHas('getOrder.gateway', function ($qq) use ($search) {
                return $qq->where('name', 'LIKE', "%{$search['payment_type']}%");
            });
        })
        ->when(@$search['payment_type'], function ($query) use ($search) {
            $query->whereHas('getOrder.gateway', function ($qq) use ($search) {
                return $qq->where('name', 'LIKE', "%{$search['payment_type']}%");
            });
        })
        ->when($date == 1, function ($query) use ($dateSearch) {
            return $query->whereDate("created_at", $dateSearch);
        })
        ->groupBy('order_id')
        ->get()
        ->each(function ($item) {
            $q = OrderDetails::where('order_id', $item->order_id)->sum('total_price');
            $item['totalAmount'] = $q;

            return $item;
        });

    $myOrderData = paginate($myOrderData, $perPage = 10, $page = null, $options = ["path" => route('user.my.order')]);

    $myOrderData = $myOrderData->appends($search);

    return view($this->theme . 'user.my_order', compact('myOrderData'));
}

}
