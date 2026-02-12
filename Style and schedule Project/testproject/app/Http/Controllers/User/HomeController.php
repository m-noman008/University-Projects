<?php

namespace App\Http\Controllers\User;

use App\Helper\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\BookAppointment;
use App\Models\Fund;
use App\Models\Gateway;
use App\Models\IdentifyForm;
use App\Models\KYC;
use App\Models\Language;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\PayoutLog;
use App\Models\PayoutMethod;
use App\Models\PlanPurchase;
use App\Models\Transaction;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;

use hisorange\BrowserDetect\Parser as Browser;

class HomeController extends Controller
{
    use Upload, Notify;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $data['orderCount'] = Order::where('user_id', $user->id)->count();
        $data['planCount'] = PlanPurchase::with('funds')->where('user_id', $user->id)->count();
        $data['wishlistCount'] = Wishlist::where('user_id', $user->id)->count();
        $data['appointmentCount'] = BookAppointment::where('user_id', $user->id)->count();
        $data['planOfServices'] = BookAppointment::where('user_id', $user->id)
            ->whereNotNull('plan_id')
            ->where('status', 0)->count();

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

        $myOrderData = paginate($myOrderData, $perPage = 5, $page = null, $options = ["path" => route('user.home')]);

        $myAppointmentDate = BookAppointment::select('date_of_appointment')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->whereDate('date_of_appointment', '>=', today())->first();

        $appointment = $myAppointmentDate ? Carbon::parse($myAppointmentDate->date_of_appointment)->format('Y-m-d') : today()->format('Y-m-d');

        return view($this->theme . 'user.dashboard', $data, compact('myOrderData', 'appointment'));

    }

    public function mybookAppointment()
    {
        $user = Auth::user();
        $bookAppointments = BookAppointment::with('service:id', 'service.serviceDetails:id,service_id,service_name')->select('id', 'service_id', 'date_of_appointment')->where('user_id', $user->id)->where('status', 1)->whereDate('date_of_appointment', '>=', today())->get();
        $data = [];
        foreach ($bookAppointments as $book) {
            $data[] = [
                'title' => optional(optional($book->service)->serviceDetails)->service_name,
                'url' => route('user.my.appointment'),
                'start' => $book->date_of_appointment

            ];
        }
        return response()->json($data);
    }


    public function fundHistory()
    {
        $funds = Fund::where('user_id', $this->user->id)->where('status', '!=', 0)->orderBy('id', 'DESC')->with('gateway')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.transaction.fundHistory', compact('funds'));
    }

    public function fundHistorySearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $funds = Fund::orderBy('id', 'DESC')->where('user_id', $this->user->id)->where('status', '!=', 0)
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('transaction', 'LIKE', $search['name']);
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->with('gateway')
            ->paginate(config('basic.paginate'));
        $funds->appends($search);

        return view($this->theme . 'user.transaction.fundHistory', compact('funds'));

    }


    public function addFund()
    {
        if (session()->get('plan_id') != null) {
            return redirect(route('user.payment'));
        }

        $data['totalPayment'] = null;
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();

        return view($this->theme . 'user.addFund', $data);
    }


    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), []);
        $data['user'] = $this->user;
        $data['languages'] = Language::all();
        return view($this->theme . 'user.edit_profile', $data);
    }


    public function updateProfile(Request $request)
    {

        $allowedExtensions = array('jpg', 'png', 'jpeg');

        $image = $request->image;
        $this->validate($request, [
            'image' => [
                'required',
                'max:4096',
                function ($fail) use ($image, $allowedExtensions) {
                    $ext = strtolower($image->getClientOriginalExtension());
                    if (($image->getSize() / 1000000) > 2) {
                        throw ValidationException::withMessages(['image' =>"Images MAX  2MB ALLOW!"]);
                    }
                    if (!in_array($ext, $allowedExtensions)) {
                        throw ValidationException::withMessages(['image' =>"Only png, jpg, jpeg images are allowed"]);
                    }
                }
            ]
        ]);
        $user = $this->user;
        if ($request->hasFile('image')) {
            $path = config('location.user.path');
            try {
                $user->image = $this->uploadImage($image, $path);
            } catch (\Exception $exp) {
                return back()->with('error', 'Could not upload your ' . $image)->withInput();
            }
        }
        $user->save();
        return back()->with('success', 'Updated Successfully.');
    }


    public function updateInformation(Request $request)
    {
        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });

        $req = Purify::clean($request->all());
        $user = $this->user;
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'username' => "sometimes|required|alpha_dash|min:5|unique:users,username," . $user->id,
            'address' => 'required',
            'language_id' => Rule::in($languages),
        ];
        $message = [
            'first_name.required' => 'First Name field is required',
            'last_name.required' => 'Last Name field is required',
        ];

        $validator = Validator::make($req, $rules, $message);
        if ($validator->fails()) {
            $validator->errors()->add('profile', '1');
            return back()->withErrors($validator)->withInput();
        }
        $user->language_id = $req['language_id'];
        $user->firstname = $req['first_name'];
        $user->lastname = $req['last_name'];
        $user->email = $req['email'];
        $user->phone = $req['phone'];
        $user->username = $req['username'];
        $user->address = $req['address'];
        $user->save();
        return back()->with('success', 'Updated Successfully.');
    }


    public function updatePassword(Request $request)
    {

        $rules = [
            'current_password' => "required",
            'password' => "required|min:5|confirmed",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('password', '1');
            return back()->withErrors($validator)->withInput();
        }
        $user = $this->user;
        try {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return back()->with('success', 'Password Changes successfully.');
            } else {
                throw new \Exception('Current password did not match');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


}
