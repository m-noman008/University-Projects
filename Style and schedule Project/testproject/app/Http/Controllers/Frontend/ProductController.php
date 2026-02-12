<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AttributesList;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class ProductController extends Controller
{

    public function getProductStockInfo(Request $request)
    {

        $stock = ProductStock::where('product_id', $request->productId)
            ->where(function ($query) use ($request) {
                if ($request->attributeIds){
                    foreach ($request->attributeIds as $key => $id) {
                        $query->whereJsonContains('attributes_id', $id);
                    }
                }
            })
            ->first();

        if (!$stock || $stock->qty == 0) {
            return [
                'status' => false,
                'stock' => 0,
                'message' => 'Out of stock'
            ];
        }

        if ($stock && $stock->qty > 0) {
            return [
                'status' => true,
                'stock' => $stock->qty,
                'message' => 'In stock'
            ];
        }

    }


    public function productStockCheck(Request $request)
    {

        $stock = ProductStock::where('product_id', $request->productId)
            ->where(function ($query) use ($request) {
                if ($request->attributeIds) {
                    foreach ($request->attributeIds as $key => $id) {
                        $query->whereJsonContains('attributes_id', $id);
                    }
                }

            })
            ->first();

        if (!$stock) {
            return [
                'status' => false,
                'stock' => 0,
                'message' => 'Out of stock'
            ];
        }

        if ($stock->qty > $request->storage_qty + 1) {
            return [
                'status' => true,
                'stock' => $stock->qty ?? 0,
            ];
        }

    }


    public function productAttributesName(Request $request)
    {

        if ($request->attributeIds){
            $newList = collect([]);
            AttributesList::with(['product_attr'])->whereIn('id', $request->attributeIds)->get()
                ->map(function ($item) use ($newList) {
                    $res = [];
                    $product_attr_key = (string)@$item->product_attr->name;
                    $res[$product_attr_key] = $item->attributes;
                    $newList->push($res);
                    return $res;
                });
            return [
                'attributes' => $newList,
            ];
        }else{
            return [
                'attributes' => null,
            ];
        }

    }

    public function checkShoppingCartItem(Request $request)
    {
        return $request->all();

        $attr = AttributesList::whereIn('id', $request->attributeIds)->get();

        $stock = ProductStock::where('product_id', $request->productId)
            ->where(function ($query) use ($request) {
                if ($request->attributeIds) {
                    foreach ($request->attributeIds as $key => $id) {
                        $query->whereJsonContains('attributes_id', $id);
                    }
                }
            })
            ->first();
        if (!$stock) {
            return [
                'status' => false,
                'productId' => $request->productId,
                'message' => 'Out of stock'
            ];
        }

        if ($stock->qty > $request->storage_qty + 1) {
            return [
                'status' => true,
                'stock' => $stock->qty,
                'storage' => $request->storage_qty ?? 0,
                'attribute' => $attr,
            ];
        }
    }









}
