<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Stevebauman\Purify\Facades\Purify;

class PlanController extends Controller
{
    use Notify, Upload;

    public function planList()
    {
        $data['plans'] = Plan::orderBy('id', 'DESC')->get();
        return view('admin.plan.list', $data);
    }

    public function planCreate()
    {
        $data['service_name'] = Service::with('serviceDetails')->latest()->get();
        return view('admin.plan.create', $data);
    }

    public function planStore(Request $request)
    {

        $purifiedData = Purify::clean($request->except('image', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }

        $request->validate([
            'name' => 'required|max:40',
            'price' => 'required|numeric',
            'service_name' => 'required',
            'image' => 'required|max:3072|image|mimes:jpg,jpeg,png',
        ]);

        $plan = new Plan();
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->services = $request->service_name;
        $plan->status = $request->status;

        if ($request->hasFile('image')) {
            try {
                $plan->image = $this->uploadImage($request->image, config('location.plan.path'), config('location.plan.size'), $plan->image);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $plan->save();
        return redirect()->route('admin.plan.list')->with('success', 'Plan Added Successfully');
    }

    public function planEdit($id)
    {
        $data['service_name'] = Service::with('serviceDetails')->latest()->get();
        $data['plans'] = Plan::findOrFail($id);
        return view('admin.plan.edit', $data);
    }

    public function planUpdate(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('image', '_token', '_method'));

        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }

        $request->validate([
            'name' => 'required|max:40',
            'price' => 'required|numeric',
            'service_name' => 'required',
            'image' => 'sometimes|required|max:3072|image|mimes:jpg,jpeg,png',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->services = $request->service_name;
        $plan->status = $request->status;

        if ($request->hasFile('image')) {
            try {
                $plan->image = $this->uploadImage($request->image, config('location.plan.path'), config('location.plan.size'), $plan->image);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $plan->save();
        return redirect()->back()->with('success', 'Plan Updated Successfully');
    }

    public function planDelete($id)
    {
        $plan = Plan::with('planPurchase')->findOrFail($id);
        if (count($plan->planPurchase) > 0) {
            return back()->with('error', 'Many plans are purchased by this plan');
        }

        $old_image = $plan->image;
        $location = config('location.plan.path');

        if (!empty($old_image)) {
            unlink($location . '/' . $old_image);
        }
        $plan->delete();
        return back()->with('success', 'Plan has been deleted');
    }
}
