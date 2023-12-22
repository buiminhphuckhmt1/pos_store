<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response(
                $request->user()->cargo()->get()
            );
        }
        return view('cargo.index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required|exists:products,barcode',
        ]);
        $barcode = $request->barcode;

        $product = Product::where('barcode', $barcode)->first();
        $cargo = $request->user()->cargo()->where('barcode', $barcode)->first();
        if ($cargo) {
            // check product quantity
            if ($product->quantity <= $cargo->pivot->quantity) {
                return response([
                    'message' => 'Product available only: ' . $product->quantity,
                ], 400);
            }
            // update only quantity
            $cargo->pivot->quantity = $cargo->pivot->quantity + 1;
            $cargo->pivot->save();
        } else {
            $request->user()->cargo()->attach($product->id, ['quantity' => 1]);
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
        $cargo = $request->user()->cargo()->where('id', $request->product_id)->first();

        if ($cargo) {
            $cargo->pivot->quantity = $request->quantity;
            $cargo->pivot->save();
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
        $request->user()->cargo()->detach($request->product_id);

        return response('', 204);
    }

    public function empty(Request $request)
    {
        $request->user()->cargo()->detach();

        return response('', 204);
    }
}
