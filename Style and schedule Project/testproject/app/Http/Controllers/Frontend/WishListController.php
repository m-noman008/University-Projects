<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishListController extends Controller
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

    public function wishList(Request $request)
    {
        $userId = $this->user->id;

        $product = Product::with('getWishList')->find($request->product_id);

        if (count($product->getWishList) > 0) {
            $stage='remove';
            $favourite = Wishlist::where('product_id',$request->product_id)->where('user_id', $userId)->first();
            $favourite->delete();

        } else {
            $stage ='added';
            $data = new Wishlist();
            $data->user_id = $request->user_id;
            $data->product_id = $request->product_id;
            $data->save();
        }

        return response()->json([
            'addNotify' => 'WishList Added Successfully',
            'removeNotify' => 'WishList Remove Successfully',
            'data' => $stage
        ]);
    }
}
