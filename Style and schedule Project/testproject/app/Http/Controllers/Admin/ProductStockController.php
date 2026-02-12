<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;


class ProductStockController extends Controller
{
    public function productStockList()
    {
        $productStock = ProductStock::with(['getProduct.details', 'getAttr'])
            ->whereHas('getProduct', function ($query) {
                $query->where('status', 1);
            })
            ->latest()
            ->groupBy('product_id')
            ->get()
            ->map(function ($item) {
                $q = ProductStock::where('product_id', $item->product_id)->sum('qty');
                $item['qty'] = $q;
                return $item;
            });


        $productStock = paginate($productStock, $perPage = '20', $page = null, $options = ["path" => route('admin.product.stock.list')]);
        return view('admin.product_stock.list', compact('productStock'));
    }

    public function productStockCreate()
    {
        $data['products'] = Product::with('details')->latest()->get();
        return view('admin.product_stock.create', $data);
    }

    public function productStockStore(Request $request)
    {

        $this->validate($request, [
            'product_name' => 'required',
            'attribute_name' => 'sometimes|required',
            'qty' => 'required'
        ]);
        if ($request->qty) {
            for ($i = 0; $i < count($request->qty); $i++) {
                $data = [
                    'product_id' => $request->product_name,
                    'attributes_id' => $request->attribute_name[$i] ?? null,
                    'qty' => $request->qty[$i],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                ProductStock::create($data);
            }
        } else {
            for ($i = 0; $i < count($request->qty); $i++) {
                $data = [
                    'product_id' => $request->product_name,
                    'qty' => $request->qty[$i],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                ProductStock::create($data);
            }
        }
        return redirect()->route('admin.product.stock.list')->with('success', 'Product Stock Successfully Saved');
    }

    public function productStockEdit($id)
    {
        $data['product'] = Product::where('status', 1)->with('details', 'stocks')->findOrFail($id);
        return view('admin.product_stock.edit', $data, compact('id'));
    }

    public function productStockUpdate(Request $request, $id)
    {

        $this->validate($request, [
            'attribute_name' => 'sometimes|required',
            'qty' => 'required',
        ]);

        $productStock = ProductStock::where('product_id', $id)->get();

        foreach ($productStock as $data) {
            $data->delete();
        }

        if ($request->qty) {
            for ($i = 0; $i < count($request->qty); $i++) {
                $data = [
                    'product_id' => $request->product_id,
                    'attributes_id' => $request->attribute_name[$i] ?? null,
                    'qty' => $request->qty[$i],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                ProductStock::create($data);
            }
        } else {
            for ($i = 0; $i < count($request->qty); $i++) {
                $data = [
                    'product_id' => $request->product_id,
                    'qty' => $request->qty[$i],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                ProductStock::create($data);
            }
        }
        return redirect()->route('admin.product.stock.list')->with('success', 'Product Stock Successfully Updated');
    }


    public function productStockSearch(Request $request)
    {
        $search = $request->all();
        $productStock = ProductStock::with('getProduct')->orderBy('id', 'DESC')
            ->when(isset($search['product_name']), function ($query) use ($search) {
                return $query->whereHas('getProduct.details', function ($q) use ($search) {
                    $q->where('product_name', 'LIKE', "%{$search['product_name']}%");
                });
            })
            ->paginate(config('basic.paginate'));

        $productStock = $productStock->appends($search);

        return view('admin.product_stock.list', compact('productStock'));
    }


}
