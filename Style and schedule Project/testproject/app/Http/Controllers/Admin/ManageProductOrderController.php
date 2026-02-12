<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;

class ManageProductOrderController extends Controller
{
    public function orderList($stage = null)
    {
        $data['orderList'] = Order::with('getOrderDetails', 'getUser', 'gateway', 'funds')
            ->where(function ($wQuery) {
                $wQuery->where(function ($query) {
                    $query->whereHas('funds', function ($qq) {
                        $qq->where('status', 1);
                    });
                })
                    ->orWhere('payment_type', '=', 'Cash On Delivery');
            })
            ->filterStatus($stage)
            ->latest()
            ->paginate(config('basic.paginate'));


        $data['all_order'] = Order::get()->count();
        $data['pending_order'] = Order::where('status', 0)->count();
        $data['processing_order'] = Order::where('status', 1)->count();
        $data['onShipping_order'] = Order::where('status', 2)->count();
        $data['completed_order'] = Order::where('status', 4)->count();
        $data['cancel_order'] = Order::where('status', 5)->count();


        return view('admin.product_order.order_list', $data);
    }

    public function orderProduct($id)
    {
        $data['OrderProductInfo'] = Order::with('getOrderDetails',)->findOrFail($id);
        $data['OrderDetailsProductInfo'] = OrderDetails::with('getOrder', 'getProductInfo',  'getProductInfo.trashDetails')->where('order_id', $id)->get();
        return view('admin.product_order.product_order_details', $data);
    }

    public function stageChange(Request $request, $orderId)
    {

        $order = Order::findOrFail($orderId);

        if ($request->stage == 'pending') {
            $order->status = '0';
            $order->save();
            return back()->with('success', 'Updated Successfully');
        }
        if ($request->stage == 'processing') {
            $order->status = '1';
            $order->save();
            return back()->with('success', 'Updated Successfully');
        }
        if ($request->stage == 'on_shipping') {
            $order->status = '2';
            $order->save();
            return back()->with('success', 'Updated Successfully');
        }
        if ($request->stage == 'completed') {
            $order->status = '4';
            $order->save();
            return back()->with('success', 'Updated Successfully');
        }
        if ($request->stage == 'cancel') {
            $order->status = '5';
            $order->save();
            return back()->with('success', 'Updated Successfully');
        }
        if ($request->stage == 'refund') {
            $order->status = '6';
            $order->save();
            return back()->with('success', 'Updated Successfully');
        }
        if ($request->stage == 'return') {
            $order->status = '7';
            $order->save();
            return back()->with('success', 'Updated Successfully');
        }
    }

    public function pending(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Order.');
            return response()->json(['error' => 1]);
        } else {
            Order::whereIn('id', $request->strIds)->update([
                'status' => 0,
            ]);
            session()->flash('success', 'Order Status Has Been Processing');
            return response()->json(['success' => 1]);
        }
    }

    public function processing(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Order.');
            return response()->json(['error' => 1]);
        } else {
            Order::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            session()->flash('success', 'Order Status Has Been Processing');
            return response()->json(['success' => 1]);
        }
    }

    public function onShipping(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Order.');
            return response()->json(['error' => 1]);
        } else {
            Order::whereIn('id', $request->strIds)->update([
                'status' => 2,
            ]);
            session()->flash('success', 'Order Status Has Been On Shipping');
            return response()->json(['success' => 1]);
        }
    }


    public function completed(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Order.');
            return response()->json(['error' => 1]);
        } else {
            Order::whereIn('id', $request->strIds)->update([
                'status' => 4,
            ]);
            session()->flash('success', 'Order Status Has Been Completed');
            return response()->json(['success' => 1]);
        }
    }

    public function cancel(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Order.');
            return response()->json(['error' => 1]);
        } else {
            Order::whereIn('id', $request->strIds)->update([
                'status' => 5,
            ]);
            session()->flash('success', 'Order Status Has Been Cancel');
            return response()->json(['success' => 1]);
        }
    }


    public function productOrderSearch(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $orderList = Order::with('getOrderDetails', 'getUser', 'gateway')->orderBy('id', 'DESC')
            ->when(isset($search['order_number']), function ($query) use ($search) {
                return $query->where('order_number', 'LIKE', "%{$search['order_number']}%");
            })
            ->when(isset($search['user_name']), function ($query) use ($search) {
                return $query->whereHas('getUser', function ($q) use ($search) {
                    $q->where('email', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('username', 'LIKE', "%{$search['user_name']}%");
                });
            })
            ->when(isset($search['payment_type']), function ($query) use ($search) {
                return $query->whereHas('gateway', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search['payment_type']}%");
                });
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));
        $orderList = $orderList->appends($search);
        return view('admin.product_order.order_list', compact('orderList'));
    }

}
