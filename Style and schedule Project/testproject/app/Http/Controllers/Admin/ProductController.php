<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductDetails;
use Illuminate\Http\Request;
use App\Http\Traits\Upload;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{

    use Upload;

    public function productList()
    {
        $data['productList'] = Product::with('details', 'category.details', 'stocks')->latest()->get();
        return view('admin.products.list', $data);
    }

    public function productCreate()
    {
        $data['languages'] = Language::all();
        $data['productCategory'] = ProductCategory::with('details')->latest()->get();
        $data['productAttribute'] = ProductAttribute::latest()->get();
        return view('admin.products.create', $data);
    }

    public function productStore(Request $request, $language)
    {

        $purifiedData = Purify::clean($request->except('thumb_image', 'slider_images', '_token', '_method'));

        if ($request->has('thumb_image')) {
            $purifiedData['thumb_image'] = $request->thumb_image;
        }

        if ($request->has('slider_images')) {
            $purifiedData['slider_images'] = $request->slider_images;
        }

        $rules = [
            'product_name.*' => 'required|max:40',
            'category_id.*' => 'sometimes|required',
            'price.*' => 'sometimes|required|sometimes',
            'description.*' => 'sometimes|required',
            'thumb_image.*' => 'required|max:3072|mimes:jpg,jpeg,png',
            'slider_images.*' => 'required|max:3072|mimes:jpg,jpeg,png',
        ];
        $message = [
            'product_name.*.required' => 'Product Name field is required',
            'product_name.*.max' => 'This field may not be greater than :max characters',
            'category_id.*.required' => 'Category Name field is required',
            'price.*.required' => 'Price field is required',
            'description.*.required' => 'Description field is required',
            'thumb_image.required' => 'Thumb Image is required',
            'slider_images.required' => 'Slider Image is required',
        ];


        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        if(!$request->category_id)
        {
            return back()->with('error', 'Category is required');
        }

        $product = new Product();
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->attributes_id = $request->attributes_id;


        if ($request->hasFile('thumb_image')) {
            try {
                $product->thumbnail_image = $this->uploadImage($request->thumb_image, config('location.product.path_thumbnail'), config('location.product.size_thumbnail'));
            } catch (\Exception $exp) {
                return back()->with('error', __('Image could not be uploaded.'));
            }
        }
        else
        {
            return back()->with('error', 'Thumb Image is required');
        }

        $slider = [];
        if ($request->hasFile('slider_images')) {
            try {
                $SliderImage = $request->slider_images;
                foreach ($SliderImage as $key => $file) {
                    $slider[] = $this->uploadImage($file, config('location.product.path_thumbnail'), config('location.product.size_thumbnail'), null);
                }
            } catch (\Exception $exp) {
                return back()->with('error', $exp)->withInput();
            }
            $product->slider_image = $slider;
        }
        else
        {
            return back()->with('error', 'Slider Image is required');
        }

        $product->save();

        $product->details()->create([
            'language_id' => $language,
            'product_name' => $purifiedData["product_name"][$language],
            'description' => $purifiedData["description"][$language],
        ]);

        return redirect()->route('admin.product.list')->with('success', 'Product Successfully Saved');
    }

    public function productEdit($id)
    {
        $languages = Language::all();
        $data['productDetails'] = ProductDetails::with('product')->where('product_id', $id)->get()->groupBy('language_id');
        $data['productCategory'] = ProductCategory::with('details')->latest()->get();
        $data['productAttribute'] = ProductAttribute::latest()->get();
        return view('admin.products.edit', $data, compact('languages', 'id'));
    }

    public function productUpdate(Request $request, $id, $language_id)
    {

        $purifiedData = Purify::clean($request->except('thumb_image', 'slider_images', '_token', '_method'));

        if ($request->has('thumb_image')) {
            $purifiedData['thumb_image'] = $request->thumb_image;
        }

        if ($request->has('slider_images')) {
            $purifiedData['slider_images'] = $request->slider_images;
        }

        $rules = [
            'product_name.*' => 'required|max:40',
            'category_id.*' => 'sometimes|required',
            'price.*' => 'sometimes|required|sometimes',
            'description.*' => 'sometimes|required',
            'thumb_image.*' => 'required|max:3072|mimes:jpg,jpeg,png',
            'slider_images.*' => 'required|max:3072|mimes:jpg,jpeg,png',
        ];
        $message = [
            'product_name.*.required' => 'Product Name field is required',
            'product_name.*.max' => 'This field may not be greater than :max characters',
            'category_id.*.required' => 'Category Name field is required',
            'price.*.required' => 'Price field is required',
            'description.*.required' => 'Description field is required',
            'thumb_image.required' => 'Thumb Image is required',
            'slider_images.required' => 'Slider Image is required',
        ];


        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $product = Product::findOrFail($id);
        if ($request->has('category_id')) {
            $product->category_id = $request->category_id;
        }
        if ($request->has('price')) {
            $product->price = $request->price;
        }

        if ($request->has('attributes_id')) {
            $product->attributes_id = $request->attributes_id;
        }


        if ($request->has('status')) {
            $product->status = $request->status;
        }

        if ($request->hasFile('thumb_image')) {
            try {
                $product->thumbnail_image = $this->uploadImage($request->thumb_image, config('location.product.path_thumbnail'), config('location.product.size_thumbnail'), $product->thumbnail_image);
            } catch (\Exception $exp) {
                return back()->with('error', __('Image could not be uploaded.'));
            }
        }

        $slider = [];
        $slider = $product->slider_image;
        if ($request->hasFile('slider_images')) {
            try {
                $SliderImage = $request->slider_images;
                foreach ($SliderImage as $key => $file) {
                    $slider[] = $this->uploadImage($file, config('location.product.path_slider'), config('location.product.size_slider'), null);
                }
            } catch (\Exception $exp) {
                return back()->with('error', $exp)->withInput();
            }
            $product->slider_image = $slider;
        }

        $product->save();

        $product->details()->updateOrCreate([
            'language_id' => $language_id
        ],
            [
                'product_name' => $purifiedData["product_name"][$language_id],
                'description' => $purifiedData["description"][$language_id],
            ]
        );

        return redirect()->route('admin.product.list')->with('success', 'Product Successfully Saved');
    }

    public function productDelete($id)
    {
        $product = Product::findOrFail($id);
        $productDetails = ProductDetails::where('product_id', $id);

        $product->delete();
        $productDetails->delete();

        return back()->with('success', 'Product has been deleted');
    }

    public function productImageDelete($id, $imgDelete)
    {
        $images = [];
        $productSliderImg = Product::findOrFail($id);
        $old_images = $productSliderImg->slider_image;
        $location = config('location.product.path_slider');

        if (!empty($old_images)) {
            foreach ($old_images as $file) {
                if ($file == $imgDelete) {
                    @unlink($location . '/' . $file);
                } elseif ($file != $imgDelete) {
                    $images[] = $file;
                }
            }
        }

        $productSliderImg->slider_image = $images;
        $productSliderImg->save();
        return back()->with('success', 'Product image has been deleted');
    }

    public function productSearch(Request $request)
    {
        $search = $request->all();

        $productList = Product::where('status', 1)->with('details', 'category')->orderBy('id', 'DESC')
            ->when(isset($search['product_name']), function ($query) use ($search) {
                return $query->whereHas('details', function ($q) use ($search) {
                    $q->where('product_name', 'LIKE', "%{$search['product_name']}%");
                });
            })
            ->when(isset($search['product_category']), function ($query) use ($search) {
                return $query->whereHas('category.details', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search['product_category']}%");
                });
            })
            ->paginate(config('basic.paginate'));
        $productList = $productList->appends($search);
        return view('admin.products.list', compact('productList'));
    }

}
