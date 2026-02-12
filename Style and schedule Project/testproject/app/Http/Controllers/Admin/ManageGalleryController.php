<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryTag;
use App\Models\ManageGallery;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use App\Http\Traits\Upload;


class ManageGalleryController extends Controller
{

    use Upload;

    /* Manage Tag */

    public function galleryTagList()
    {
        $manageTags = GalleryTag::latest()->get();
        return view('admin.manage_gallery.tags', compact('manageTags'));
    }

    public function galleryTagStore(Request $request)
    {
        $reqData = Purify::clean($request->except('_token', '_method'));
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tag Name is required'
        ]);
        $data = new GalleryTag();
        $data->name = $reqData['name'];
        $data->save();
        return back()->with('success', 'Tag Added Successfully.');
    }

    public function galleryTagUpdate(Request $request, $id)
    {

        $reqData = Purify::clean($request->except('_token', '_method'));
        $request->validate([
            'name' => 'required|string',
        ], [
            'name.required' => 'Name is required',
        ]);

        $data = GalleryTag::findOrFail($id);
        $data->name = $reqData['name'];
        $data->save();
        return back()->with('success', 'Tag Update Successfully.');
    }

    public function galleryTagDelete($id)
    {
        $tag = GalleryTag::findOrFail($id);
        $tag->delete();
        return back()->with('success', 'Tag has been deleted');
    }

    /* Manage Gallery Items */

    public function galleryItemsList()
    {
        $manageGalleries = ManageGallery::with('tag')->latest()->get();
        return view('admin.manage_gallery.list', compact('manageGalleries'));
    }

    public function galleryItemsCreate()
    {
        $manageTag = GalleryTag::latest()->get();
        return view('admin.manage_gallery.create', compact('manageTag'));
    }

    public function galleryItemsStore(Request $request)
    {

        $reqData = Purify::clean($request->except('_token', '_method'));
        $request->validate([
            'tag_id' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

        $data = new ManageGallery();
        $data->tag_id = $reqData['tag_id'];

        if ($request->hasFile('image')) {
            try {
                $data->image = $this->uploadImage($request->image, config('location.gallery.path'));
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $data->save();

        return redirect()->route('admin.gallery.items.list')->with('success', 'Gallery has been added successfully');
    }

    public function galleryItemsEdit($id)
    {
        $data['gallery'] = ManageGallery::findOrFail($id);
        $data['tags'] = GalleryTag::latest()->get();
        return view('admin.manage_gallery.edit', $data);
    }

    public function galleryItemsUpdate(Request $request, $id)
    {

        $data = ManageGallery::findOrFail($id);

        $request->validate([
            'tag_id' => 'required',
            'image' => 'sometimes|mimes:jpg,jpeg,png',
        ]);

        $reqData = Purify::clean($request->except('_token', 'image','_method'));

        if ($request->has('image')) {
            $reqData['image'] = $request->image;
        }

        $data->tag_id = $reqData['tag_id'];

        if ($request->hasFile('image')) {

            try {
                $old = $data->image ? : null;
                $image = $this->uploadImage($request->image, config('location.gallery.path'), null, $old, null, null);
                $data->image = $image ? : $data->image;
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $data->save();

        return back()->with('success', 'Gallery has been Updated');
    }

    public function galleryItemsDelete($id){

        $galleryData = ManageGallery::findOrFail($id);
        $old_image = $galleryData->image;
        $location = config('location.gallery.path');

        if (!empty($old_image)) {
            unlink($location . '/' . $old_image);
        }

        $galleryData->delete();
        return back()->with('success', 'Gallery has been deleted');
    }

}
