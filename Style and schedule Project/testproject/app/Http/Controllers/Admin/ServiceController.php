<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Service;
use App\Models\ServiceDetails;
use Illuminate\Http\Request;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

    use Upload, Notify;


    public function serviceList()
    {
        $data['manageServices'] = Service::with('serviceDetails')->latest()->get();
        return view('admin.services.list', $data);
    }

    public function serviceCreate()
    {
        $data['languages'] = Language::all();
        return view('admin.services.create', $data);
    }

    public function serviceStore(Request $request, $language)
    {

        $purifiedData = Purify::clean($request->except('thumbnail_image', 'description_image', '_token', '_method'));

        if ($request->has('thumbnail_image')) {
            $purifiedData['thumbnail_image'] = $request->thumbnail_image;
        }
        else{
            return back()->with('error', 'Thumbnail Image is required');
        }

        if ($request->has('description_image')) {
            $purifiedData['description_image'] = $request->thumbnail_image;
        }
        else
        {
            return back()->with('error', 'Description Image is required');
        }

        $rules = [
            'service_name.*' => 'required|max:100',
            'short_title.*' => 'required|max:200',
            'price' => 'sometimes|required',
            'description.*' => 'required|max:2000',
            'thumbnail_image' => 'sometimes|required|max:3072|mimes:jpg,jpeg,png',
            'description_image' => 'sometimes|required|max:3072|mimes:jpg,jpeg,png',
        ];

        $message = [
            'service_name.*.required' => 'Service Name field is required',
            'service_name.*.max' => 'This field may not be greater than :max characters',
            'short_title.*.required' => 'Short Title field is required',
            'price' => 'This  field must be an price',
            'description.*.required' => 'Description field is required',
            'thumbnail_image.required' => 'Thumbnail Image is required',
            'description_image.required' => 'Image is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $service = new Service();

        if ($request->has('price')) {
            $service->price = $purifiedData['price'];
        }

        if ($request->hasFile('thumbnail_image')) {
            $service->thumbnail = $this->uploadImage($request->thumbnail_image, config('location.service.pathThumbnail'), config('location.service.sizeThumbnail'), null, null);
        }

        if ($request->hasFile('description_image')) {
            $service->image = $this->uploadImage($request->description_image, config('location.service.pathImage'), config('location.service.sizeImage'), null, null);
        }

        $service->save();

        $service->serviceDetails()->create([
            'language_id' => $language,
            'service_name' => $purifiedData["service_name"][$language],
            'short_title' => $purifiedData["short_title"][$language],
            'description' => $purifiedData["description"][$language],
        ]);

        return redirect()->route('admin.service.list')->with('success', 'Service Successfully Saved');
    }

    public function serviceDelete($id)
    {
        $serviceData = Service::findOrFail($id);

        $old_image = $serviceData->image;
        $old_thumb_image = $serviceData->thumbnail;

        $location = config('location.service.pathImage');

        if (!empty($old_image)) {
            unlink($location . '/' . $old_image);
        }

        $locationThumb = config('location.service.pathThumbnail');

        if (!empty($old_thumb_image)) {
            unlink($locationThumb . '/' . $old_thumb_image);
        }

        $serviceDetailsData = ServiceDetails::where('service_id', $id);
        $serviceDetailsData->delete();

        $serviceData->delete();
        return back()->with('success', 'Service has been deleted');

    }

    public function serviceEdit($id)
    {
        $data['languages'] = Language::all();
        $data['serviceData'] = ServiceDetails::with('service')->where('service_id', $id)->get()->groupBy('language_id');
        return view('admin.services.edit', $data, compact('id'));
    }

    public function serviceUpdate(Request $request, $id, $language_id)
    {

        $purifiedData = Purify::clean($request->except('thumbnail_image', 'description_image', '_token', '_method'));

        if ($request->has('thumbnail_image')) {
            $purifiedData['thumbnail_image'] = $request->thumbnail_image;
        }

        if ($request->has('description_image')) {
            $purifiedData['description_image'] = $request->thumbnail_image;
        }

        $rules = [
            'service_name.*' => 'required|max:100',
            'short_title.*' => 'required|max:200',
            'price' => 'sometimes|required',
            'description.*' => 'required|max:2000',
            'thumbnail_image' => 'sometimes|max:3072|mimes:jpg,jpeg,png',
        ];

        $message = [
            'service_name.*.required' => 'Service Name field is required',
            'service_name.*.max' => 'This field may not be greater than :max characters',
            'short_title.*.required' => 'Short Title field is required',
            'price' => 'This  field must be an price',
            'description.*.required' => 'Description field is required',
            'thumbnail_image.required' => 'Thumbnail Image is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $service = Service::findOrFail($id);

        if ($request->has('price')) {
            $service->price = $purifiedData['price'];
        }


        if ($request->hasFile('thumbnail_image')) {
            $service->thumbnail = $this->uploadImage($request->thumbnail_image, config('location.service.pathThumbnail'), config('location.service.sizeThumbnail'), $service->thumbnailnull);
        }

        if ($request->hasFile('description_image')) {
            $service->image = $this->uploadImage($request->description_image, config('location.service.pathImage'), config('location.service.sizeImage'), $service->image);
        }

        $service->save();


        $service->serviceDetails()->updateOrCreate([
            'language_id' => $language_id,
            'service_id' => $service->id,
        ],
            [
                'service_name' => $purifiedData["service_name"][$language_id],
                'short_title' => $purifiedData["short_title"][$language_id],
                'description' => $purifiedData["description"][$language_id],
            ]
        );

        return redirect()->back()->with('success', 'Service Updated Successfully');
    }


}
