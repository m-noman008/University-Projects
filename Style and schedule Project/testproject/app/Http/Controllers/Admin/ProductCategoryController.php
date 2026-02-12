<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\ProductCategory;
use App\Models\ProductCategoryDetails;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function productCategoryList()
    {
        $data['productCategory'] = ProductCategory::with('details')->latest()->get();
        return view('admin.product_category.list', $data);
    }

    public function productCategoryCreate()
    {
        $data['languages'] = Language::all();
        return view('admin.product_category.create', $data);
    }

    public function productCategoryStore(Request $request, $language)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'category_name.*' => 'required|max:40',
        ];

        $message = [
            'category_name.*.required' => 'Category Name field is required',
            'category_name.*.max' => 'This field may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $category = new ProductCategory();
        $category->save();

        $category->details()->create([
            'language_id' => $language,
            'name' => $purifiedData["category_name"][$language],
        ]);

        return redirect()->route('admin.product.category.list')->with('success', 'Product Category Successfully Saved');
    }

    public function productCategoryDelete($id)
    {
        $categoryData = ProductCategory::with('products')->findOrFail($id);

        if (count($categoryData->products) > 0) {
            return back()->with('error', 'One or More Product Under This Category!');
        }

        $categoryDetailsData = ProductCategoryDetails::where('category_id', $id);
        $categoryData->delete();
        $categoryDetailsData->delete();
        return back()->with('success', 'Category has been deleted');
    }

    public function productCategoryEdit($id)
    {
        $languages = Language::all();
        $categoryDetails = ProductCategoryDetails::with('category')->where('category_id', $id)->get()->groupBy('language_id');
        return view('admin.product_category.edit', compact('languages', 'categoryDetails', 'id'));
    }

    public function productCategoryUpdate(Request $request, $language_id, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'category_name.*' => 'required|max:40',
        ];

        $message = [
            'category_name.*.required' => 'Category Name field is required',
            'category_name.*.max' => 'This field may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $category = ProductCategory::findOrFail($id);
        $category->save();

        $category->details()->updateOrCreate([
            'language_id' => $language_id,
        ],
            [
                'name' => $purifiedData["category_name"][$language_id],
            ]
        );

        return redirect()->route('admin.product.category.list')->with('success', 'Product Category Updated Successfully');
    }


}
