<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\OrderDetails;
use App\Models\ReviewRating;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewRatingController extends Controller
{
    public function addReviewRating(Request $request)
    {

        $request->validate([
            'comment' => 'required|max:200',
            'rating' => 'required|integer|not_in:0|min:1|max:5',
        ]);


        $user = auth()->user();

        $purchase_verified = OrderDetails::with('getOrder')->where('product_id', $request->product_id)
            ->whereHas('getOrder', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->first();

        if (!$purchase_verified)
            return back()->with('error', "You can't rate this product without purchase.");

        $isRatingExists = ReviewRating::where('product_id', $request->product_id)
            ->whereHasMorph(
                'ratingable',
                User::class,
                function (Builder $query) use ($user) {
                    $query->where('ratingable_id', $user->id);
                }
            )->count();

        if ($isRatingExists > 0)
            return back()->with('error', "You have already rated this product.");

        $user->rating()->create([
            'product_id' => $request->product_id,
            'review' => $request->comment,
            'rating' => $request->rating,
        ]);
        return back()->with('success', 'Thank you for rate this product.');

    }

    public function reply(Request $request, $parentId)
    {

        if(Auth::guard('admin')->check())
        {
            $request->validate([
                'reply' => 'required|max:200',
            ]);

            $admin = Admin::first();
            $isReplyExists = ReviewRating::where('product_id', $request->product_id)->where('parent_id', $parentId)->count();

            if ($isReplyExists > 0)
                return back()->with('error', "You have already reply this comment.");

            $admin->rating()->create([
                'product_id' => $request->product_id,
                'review' => $request->reply,
                'parent_id' => $parentId,
            ]);

            return back()->with('success', 'Reply Successfully.');
        }

    }

}
