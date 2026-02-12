<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyWishListController extends Controller
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

    public function myWishList()
    {
        $user = Auth::user();
        $data['wishlist_data'] = Wishlist::with('productInfo.details')->where('user_id', $user->id)->latest()->paginate(10);
        return view($this->theme . 'user.my_wishlist', $data);
    }

    public function searchWishlist(Request $request)
    {
        $user = Auth::user();
        $search = $request->all();
        $dateSearch = $request->date;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $wishlist_data = Wishlist::where('user_id', $user->id)
            ->when(@$search['product_name'], function ($query) use ($search) {
                $query->whereHas('getProduct.details', function ($qq) use ($search) {
                    return $qq->where('product_name', 'LIKE', "%{$search['product_name']}%");
                });
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(10);

        $wishlist_data = $wishlist_data->appends($search);

        return view($this->theme . 'user.my_wishlist', compact('wishlist_data'));
    }

    public function myWishListDelete($id)
    {
        $wishList = Wishlist::findOrFail($id);
        $wishList->delete();
        return back()->with('success', 'Wishlist deleted successfully');
    }
}
