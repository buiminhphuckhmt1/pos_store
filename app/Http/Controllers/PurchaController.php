<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PurchaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response(
                $request->user()->purcha()->get()
            );
        }
        return view('purcha.index');
    }
    public function storecus(SupplierStoreRequest $request)
    {
        $supplier = Supplier::create([
            'name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => $request->user()->id,
        ]);

        if (!$supplier) {
            return redirect()->back()->with('Lỗi', 'Xin lỗi đã gặp vấn đề trong lúc tạo khách hàng mới.');
        }
        return redirect()->route('suppliers.index')->with('Thành công', 'Đã tạo khách hàng mới thành công.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required|exists:products,barcode',
        ]);
        $barcode = $request->barcode;

        $product = Product::where('barcode', $barcode)->first();
        $purcha = $request->user()->purcha()->where('barcode', $barcode)->first();
        if ($purcha) {
            // check product quantity
            if ($product->quantity <= $purcha->pivot->quantity) {
                return response([
                    'message' => 'Sản phẩm có sẵn: ' . $product->quantity,
                ], 400);
            }
            // update only quantity
            $purcha->pivot->quantity = $purcha->pivot->quantity + 1;
            $purcha->pivot->save();
        } else {
            if ($product->quantity < 1) {
                return response([
                    'message' => 'Sản phẩm đã hết',
                ], 400);
            }
            $request->user()->purcha()->attach($product->id, ['quantity' => 1]);
        }

        return response('', 204);
    }

    public function changeQty(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        $purcha = $request->user()->purcha()->where('id', $request->product_id)->first();

        if ($purcha) {
            // check product quantity
            if ($product->quantity < $request->quantity) {
                return response([
                    'message' => 'Sản phẩm có sẵn: ' . $product->quantity,
                ], 400);
            }
            $purcha->pivot->quantity = $request->quantity;
            $purcha->pivot->save();
        }

        return response([
            'success' => true
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);
        $request->user()->purcha()->detach($request->product_id);

        return response('', 204);
    }

    public function empty(Request $request)
    {
        $request->user()->purcha()->detach();

        return response('', 204);
    }
}
