<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Content;
use App\Models\GalleryTag;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\ManageGallery;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Plan;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ReviewRating;
use App\Models\Service;
use App\Models\Team;
use App\Models\Template;
use App\Models\Subscriber;
use App\Http\Traits\Notify;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\ContentDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    use Notify;

    public function __construct()
    {
        $this->theme = template();
    }

    public function index()
    {
        $templateSection = ['hero', 'about-area', 'open-shop', 'experience', 'speciality', 'process-behind', 'team',  'book-appointment', 'why-chose-us', 'services', 'gallery', 'plan', 'testimonial', 'faq',];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $contentSection = ['hero', 'social', 'open-shop-schedule', 'experience', 'speciality', 'why-chose-us', 'testimonial', 'faq'];
        $data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $data['galleryTag'] = GalleryTag::get();
        $data['manageGallery'] = ManageGallery::latest()->get();
        $data['servicesName'] = Service::with('serviceDetails')->latest()->get();
        $data['plans'] = Plan::where('status', 1)->get();
        $data['team_member'] = Team::with('teamDetails')->latest()->get();
        return view($this->theme . 'home', $data);
    }


    public function about()
    {

        $templateSection = ['about-us', 'why-chose-us', 'team', 'open-shop', 'faq'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $contentSection = ['why-chose-us'];
        $data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $data['team_member'] = Team::with('teamDetails')->latest()->get();
        return view($this->theme . 'about', $data);
    }

    public function service()
    {
        $templateSection = ['facts'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $contentSection = ['facts'];
        $data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $data['title'] = 'Services';
        $data['services'] = Service::with('serviceDetails')->latest()->get();
        return view($this->theme . 'service', $data);
    }

    public function serviceDetails($slug = null, $id)
    {
        $templateSection = ['need-help'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $data['title'] = 'Service Details';
        $data['service_details'] = Service::with('serviceDetails')->findOrFail($id);
        $data['services'] = Service::with('serviceDetails')->latest()->get();
        return view($this->theme . 'service_details', $data);
    }



    public function appointment()
    {
        $data['title'] = 'Appointment';
        $data['servicesName'] = Service::with('serviceDetails')->latest()->get();

        $templateSection = ['book-appointment'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        return view($this->theme . 'appointment', $data);

    }

    public function team()
    {

        $templateSection = ['team'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');


        $data['title'] = 'Team';
        $data['team_member'] = Team::with('teamDetails')->latest()->get();
        return view($this->theme . 'team', $data);
    }

    public function teamDetails($slug = null, $id)
    {

        $data['title'] = 'Team Details';
        $data['team_details'] = Team::with('teamDetails')->findOrFail($id);
        return view($this->theme . 'team_details', $data);
    }

    public function pricingPlan()
    {
        $templateSection = ['plan'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $data['title'] = 'Pricing Plan';
        $data['plans'] = Plan::where('status', 1)->get();
        return view($this->theme . 'pricing_plan', $data);
    }

    public function gallery()
    {
        $templateSection = ['gallery'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $data['title'] = "Gallery";
        $data['galleryTag'] = GalleryTag::get();
        $data['manageGallery'] = ManageGallery::latest()->get();
        return view($this->theme . 'gallery', $data);
    }


    public function faq()
    {

        $templateSection = ['faq'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $contentSection = ['faq'];
        $data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $data['increment'] = 1;
        return view($this->theme . 'faq', $data);
    }


    public function products(Request $request)
    {
        $selectQuery = DB::table('products');

        if ($request->my_range) {
            $min = $request->minPrice;
            $max = $request->maxPrice;
        } else {
            $selectQuery = DB::table('products');
            $max = $selectQuery->max('price');
            $min = $selectQuery->min('price');
        }

        $data['max'] = $max;
        $data['min'] = $min;
        $data['rangeMax'] = $selectQuery->max('price');

        $data['title'] = 'Products';
        $data['productAttribute'] = ProductAttribute::with('attributes')->get();
        $data['all_products'] = Product::where('status', 1)->with('details', 'category.details')->withCount('category')->where('status', 1)->paginate(10);
        $data['product_category'] = ProductCategory::with('details', 'products')->withCount('products')->get();
        return view($this->theme . 'products', $data);
    }

    public function productFilter(Request $request)
    {

        $selectQuery = DB::table('products');

        if ($request->my_range) {
            $min = $request->minPrice;
            $max = $request->maxPrice;
        } else {
            $selectQuery = DB::table('products');
            $max = $selectQuery->max('price');
            $min = $selectQuery->min('price');
        }

        $data['min'] = $min;
        $data['max'] = $max;
        $data['rangeMax'] = $selectQuery->max('price');

        $search = $request->search;

        $data['all_products'] = Product::where('status', 1)->with('details', 'category', 'stocks')
            ->when(isset($request->productAttributes), function ($query) use ($request) {
                $query->whereHas('stocks', function ($qq) use ($request) {
                    foreach ($request->productAttributes as $key => $id) {
                        if ($key == 0) {
                            $qq->whereJsonContains('attributes_id', $id);
                        } else {
                            $qq->orWhereJsonContains('attributes_id', $id);
                        }

                    }

                });
            })
            ->when(isset($request->search), function ($query) use ($search) {
                $query->whereHas('details', function ($qq2) use ($search) {
                    $qq2->where('product_name', 'Like', '%' . $search . '%');
                });
            })
            ->when(isset($request->category_id), function ($query) use ($request) {
                $query->whereIn('category_id', $request->category_id);
            })
            ->whereBetween('price', [$min, $max])
            ->latest()->paginate(10);

        $data['title'] = 'Products';
        $data['productAttribute'] = ProductAttribute::with('attributes')->get();
        $data['product_category'] = ProductCategory::with('details', 'products')->withCount('products')->get();

        return view($this->theme . 'products', $data);
    }

    public function productSorting(Request $request, $value)
    {

        $selectQuery = DB::table('products');

        if ($request->my_range) {
            $min = $request->minPrice;
            $max = $request->maxPrice;
        } else {
            $selectQuery = DB::table('products');
            $max = $selectQuery->max('price');
            $min = $selectQuery->min('price');
        }

        $data['max'] = $max;
        $data['min'] = $min;
        $data['rangeMax'] = $selectQuery->max('price');

        $data['title'] = 'Products';
        $data['productAttribute'] = ProductAttribute::with('attributes')->get();

        if ($value == 'latest') {
            $data['all_products'] = Product::where('status', 1)->with('details', 'category.details')
                ->withCount('category')
                ->where('status', 1)
                ->latest()->paginate(10);
        } elseif ($value == 'low_to_high') {
            $data['all_products'] = Product::where('status', 1)->with('details', 'category.details')
                ->withCount('category')
                ->where('status', 1)
                ->orderBy('price', 'ASC')->paginate(10);
        } elseif ($value == 'high_to_low') {
            $data['all_products'] = Product::where('status', 1)->with('details', 'category.details')
                ->withCount('category')
                ->where('status', 1)
                ->orderBy('price', 'DESC')->paginate(10);
        }

        $data['product_category'] = ProductCategory::with('details', 'products')->withCount('products')->get();
        return view($this->theme . 'products', $data);
    }

    public function productDetails($slug = null, $id)
    {
        $templateSection = ['business-policy'];
        $data['templates'] = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $user = auth()->user();
        $admin = Admin::first();

        $data['id'] = $id;
        $data['title'] = 'Product Details';
        $data['product_details'] = Product::where('status', 1)
            ->when(Auth::guard('admin')->check() != true, function ($query) {
                $query->with('details', 'ratings', 'ratings.ratingable', 'ratings.reply.ratingable');
            })
            ->when(Auth::guard('admin')->check() == true, function ($query) {
                $query->with('trashDetails', 'category', 'stocks')->withTrashed();
            })
            ->findOrFail($id);

        $sumRating = $data['product_details']->ratings->sum('rating');
        $countRating = $data['product_details']->ratings->count();

        if ($countRating == 0) {
            $countRating = 1;
        }

        $data['averageRating'] = $sumRating / $countRating;

        $data['isRatingExists'] = ReviewRating::where('product_id', $id)
            ->whereHasMorph(
                'ratingable',
                User::class,
                function (Builder $query) use ($user) {
                    if ($user) {
                        $query->where('ratingable_id', $user->id);
                    }

                }
            )->count();

        $data['isReplyExists'] = ReviewRating::where('product_id', $id)
            ->whereHasMorph(
                'ratingable',
                User::class,
                function (Builder $query) use ($admin) {
                    if ($admin) {
                        $query->where('ratingable_id', $admin->id);
                    }

                }
            )->count();

        return view($this->theme . 'product_details', $data);
    }

    public function shoppingCart()
    {
        $data['title'] = 'Shopping Cart';
        return view($this->theme . 'shopping_cart', $data);
    }

    public function checkout()
    {
        $data['title'] = 'Checkout';
        $data['gateways'] = Gateway::where('status', 1)->get();
        return view($this->theme . 'checkout', $data);
    }

    public function orderConfirm($id)
    {
        $data['title'] = 'Order Confirmation';
        $data['orderInfo'] = Order::with('getOrderDetails')->findOrFail($id);
        $data['productOrder'] = OrderDetails::with('getProductInfo.details')->where('order_id', $id)->get();
        return view($this->theme . 'order_confirmation', $data);
    }


    public function contact()
    {
        $templateSection = ['contact-us'];
        $templates = Template::templateMedia()->whereIn('section_name', $templateSection)->get()->groupBy('section_name');

        $contentSection = ['social'];

        $data['contentDetails'] = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $title = 'Contact Us';
        $contact = @$templates['contact-us'][0]->description;

        return view($this->theme . 'contact', $data, compact('title', 'contact'));
    }

    public function contactSend(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|max:91',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
        ]);
        $requestData = Purify::clean($request->except('_token', '_method'));

        $basic = (object)config('basic');
        $basicEmail = $basic->sender_email;

        $name = $requestData['name'];
        $email_from = $requestData['email'];
        $subject = $requestData['subject'];
        $message = $requestData['message'] . "<br>Regards<br>" . $name;
        $from = $email_from;

        $headers = "From: <$from> \r\n";
        $headers .= "Reply-To: <$from> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $to = $basicEmail;

        if (@mail($to, $subject, $message, $headers)) {
            // echo 'Your message has been sent.';
        } else {
            //echo 'There was a problem sending the email.';
        }

        return back()->with('success', 'Mail has been sent');
    }

    public function getLink($getLink = null, $id)
    {
        $getData = Content::findOrFail($id);

        $contentSection = [$getData->name];
        $contentDetail = ContentDetails::select('id', 'content_id', 'description', 'created_at')
            ->where('content_id', $getData->id)
            ->whereHas('content', function ($query) use ($contentSection) {
                return $query->whereIn('name', $contentSection);
            })
            ->with(['content:id,name',
                'content.contentMedia' => function ($q) {
                    $q->select(['content_id', 'description']);
                }])
            ->get()->groupBy('content.name');

        $title = @$contentDetail[$getData->name][0]->description->title;
        $description = @$contentDetail[$getData->name][0]->description->description;
        return view($this->theme . 'getLink', compact('contentDetail', 'title', 'description'));
    }

    public function subscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255|unique:subscribers'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(url()->previous() . '#subscribe')->withErrors($validator);
        }
        $data = new Subscriber();
        $data->email = $request->email;
        $data->save();
        return redirect(url()->previous() . '#subscribe')->with('success', 'Subscribed Successfully');
    }

    public function language($code)
    {
        $language = Language::where('short_name', $code)->first();
        if (!$language) $code = 'US';
        session()->put('trans', $code);
        session()->put('rtl', $language ? $language->rtl : 0);
        return redirect()->back();
    }


}
