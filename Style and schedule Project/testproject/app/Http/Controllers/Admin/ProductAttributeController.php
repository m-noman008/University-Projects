<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttributesList;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class ProductAttributeController extends Controller
{
    public function productAttributeList()
    {
        $data['manageProductAttribute'] = ProductAttribute::get();
        return view('admin.product_attribute.list', $data);
    }

    public function productAttributeCreate()
    {
        return view('admin.product_attribute.create');
    }

    public function productAttributeStore(Request $request)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|max:40',
        ];

        $message = [
            'name.required' => 'Attribute Name field is required',
            'name.max' => 'This field may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $attribute = new ProductAttribute();
        $attribute->name = $request->name;
        $attribute->save();

        for ($i = 0; $i < count($request->attr); $i++) {
            $attr = AttributesList::firstOrNew([
                'attribute_id' => $attribute->id,
                'attributes' => $request->attr[$i]
            ]);
            $attr->save();
        }

        return redirect()->route('admin.product.attribute.list')->with('success', 'Product Attribute Successfully Saved');
    }

    public function productAttributeDelete($id)
    {
        $attributeData = ProductAttribute::with('products')->findOrFail($id);

        $product = Product::whereJsonContains('attributes_id', json_encode($attributeData->id))->exists();
        if ($product == true) {
            return back()->with('error', 'Attributes has lot of products');
        }

        $attributeData->delete();
        $attributesListData = AttributesList::where('attribute_id', $id)->first();
        $attributesListData->delete();
        return back()->with('success', 'Product Attribute has been deleted');
    }

    public function productAttributeEdit($id)
    {
        $data['attributesList'] = AttributesList::whereAttribute_id($id)->get();
        $data['productAttributes'] = ProductAttribute::findOrFail($id);
        return view('admin.product_attribute.edit', $data, compact('id'));
    }

    public function productAttributeUpdate(Request $request, $id)
    {
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => 'required|max:40',
        ];

        $message = [
            'name.required' => 'Attribute Name field is required',
            'name.max' => 'This field may not be greater than :max characters',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $attribute = ProductAttribute::findOrFail($id);
        $attribute->name = $request->name;
        $attribute->save();

        $proAttr = AttributesList::where('attribute_id', $id)->get();

        for ($i = 0; $i < count($request->attr); $i++) {
            $attr = AttributesList::firstOrNew([
                'attribute_id' => $attribute->id,
                'attributes' => $request->attr[$i]
            ]);
            $attr->save();
        }

        return redirect()->back()->with('success', 'Product Attribute Successfully Saved');
    }
}
