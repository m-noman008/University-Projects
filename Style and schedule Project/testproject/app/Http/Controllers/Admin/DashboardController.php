<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Upload;
use App\Models\BookAppointment;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\PayoutLog;
use App\Models\Plan;
use App\Models\PlanPurchase;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;
use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    use Upload;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    public function forbidden()
    {
        return view('admin.errors.403');
    }


    public function dashboard()
    {
        $data['plans'] = collect(Plan::selectRaw('COUNT(id) AS totalPlans')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS activePlans')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS inactivePlans')
            ->get()->toArray())->collapse();

        $data['orders'] = collect(Order::selectRaw('COUNT(id) AS totalOrders')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS pendingOrders')
            ->selectRaw('COUNT(CASE WHEN status = 4 THEN id END) AS completeOrders')
            ->selectRaw('COUNT(CASE WHEN status = 5 THEN id END) AS cancelOrders')
            ->get()->toArray())->collapse();

        $data['totalPurchasePlans'] = PlanPurchase::count();
        $data['totalProducts'] = Product::count();
        $data['totalProductsSell'] = OrderDetails::sum('total_price');
        $data['totalBookAppointment'] = BookAppointment::count();

        $data['funding'] = collect(Fund::selectRaw('SUM(CASE WHEN status = 1 THEN amount END) AS totalAmountReceived')
            ->selectRaw('SUM(CASE WHEN status = 1 THEN charge END) AS totalChargeReceived')
            ->selectRaw('SUM((CASE WHEN created_at >= CURDATE() AND status = 1 THEN amount END)) AS todayDeposit')
            ->get()->toArray())->collapse();

        $data['userRecord'] = collect(User::selectRaw('COUNT(id) AS totalUser')
            ->selectRaw('count(CASE WHEN status = 1  THEN id END) AS activeUser')
            ->selectRaw('SUM(balance) AS totalUserBalance')
            ->selectRaw('COUNT((CASE WHEN created_at >= CURDATE()  THEN id END)) AS todayJoin')
            ->get()->makeHidden(['fullname', 'mobile'])->toArray())->collapse();


        $data['tickets'] = collect(Ticket::where('created_at', '>', Carbon::now()->subDays(30))
            ->selectRaw('count(CASE WHEN status = 3  THEN status END) AS closed')
            ->selectRaw('count(CASE WHEN status = 2  THEN status END) AS replied')
            ->selectRaw('count(CASE WHEN status = 1  THEN status END) AS answered')
            ->selectRaw('count(CASE WHEN status = 0  THEN status END) AS pending')
            ->get()->toArray())->collapse();

        /*
         * Pie Chart Data
         */
        $totalSell = 100;

        $Gateways = Gateway::where('status', 1)->count('id');
        $data['Gateways'] = $Gateways;
        $pieLog = collect();

        Order::where('status', 1)->with('gateway:id,name')
            ->get()->groupBy('gateway.name')->map(function ($items, $key) use ($Gateways, $pieLog) {
                $pieLog->push(['level' => $key, 'value' => round((0 < $Gateways) ? (count($items) / $Gateways * 100) : 0, 2)]);
                return $items;
            });

        $dailyOrder = $this->dayList();

        Order::whereMonth('created_at', Carbon::now()->month)
            ->select(
                DB::raw('count(id) as totalOrders'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get()->map(function ($item) use ($dailyOrder) {
                $dailyOrder->put($item['date'], $item['totalOrders']);
            });
        $statistics['totalOrders'] = $dailyOrder;


        $dailyPlanPurchase = $this->dayList();

        PlanPurchase::whereMonth('created_at', Carbon::now()->month)
            ->select(
                DB::raw('count(id) as totalPlanPurchase'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get()->map(function ($item) use ($dailyPlanPurchase) {
                $dailyPlanPurchase->put($item['date'], round($item['totalPlanPurchase'], 2));
            });
        $statistics['totalPlanPurchase'] = $dailyPlanPurchase;

        $statistics['schedule'] = $this->dayList();


        $data['latestUser'] = User::latest()->limit(5)->get();

        return view('admin.dashboard', $data, compact('statistics', 'pieLog','statistics'));
    }

    public function dayList()
    {
        $totalDays = Carbon::now()->endOfMonth()->format('d');
        $daysByMonth = [];
        for ($i = 1; $i <= $totalDays; $i++) {
            array_push($daysByMonth, ['Day ' . sprintf("%02d", $i) => 0]);
        }

        return collect($daysByMonth)->collapse();
    }

    public function profile()
    {
        $admin = $this->user;
        return view('admin.profile', compact('admin'));
    }


    public function profileUpdate(Request $request)
    {
        $req = Purify::clean($request->except('_token', '_method'));
        $rules = [
            'name' => 'sometimes|required',
            'username' => 'sometimes|required|unique:admins,username,' . $this->user->id,
            'email' => 'sometimes|required|email|unique:admins,email,' . $this->user->id,
            'phone' => 'sometimes|required',
            'address' => 'sometimes|required',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = $this->user;
        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = $this->uploadImage($request->image, config('location.admin.path'), config('location.admin.size'), $old);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }
        $user->name = $req['name'];
        $user->username = $req['username'];
        $user->email = $req['email'];
        $user->phone = $req['phone'];
        $user->address = $req['address'];
        $user->save();

        return back()->with('success', 'Updated Successfully.');
    }


    public function password()
    {
        return view('admin.password');
    }

    public function passwordUpdate(Request $request)
    {
        $req = Purify::clean($request->all());

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $request = (object)$req;
        $user = $this->user;
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', "Password didn't match");
        }
        $user->update([
            'password' => bcrypt($request->password)
        ]);
        return back()->with('success', 'Password has been Changed');
    }
}
