<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurcharStoreRequest;
use App\Models\Purchar;
use App\Models\Customer;
use App\Models\PurcharItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class PurcharController extends Controller
{
    public function index(Request $request) {
        $purchars = new Purchar();
        $purcharss = new Purchar();
        if($request->start_date) {
            $purchars = $purchars->where('created_at', '>=', $request->start_date);
            $purcharss = $purcharss->where('created_at', '>=', $request->start_date);
        }
        if($request->end_date) {
            $purchars = $purchars->where('created_at', '<=', $request->end_date . ' 23:59:59');
            $purcharss = $purcharss->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
        $purchars = $purchars->with(['items', 'paymentpurs', 'supplier'])->latest()->paginate(10);
        $purcharss = $purcharss->with(['items', 'paymentpurs', 'supplier'])->latest()->paginate(1000);
        $total = $purcharss->map(function($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $purcharss->map(function($i) {
            return $i->receivedAmount();
        })->sum();
        $receivedDiscount = $purcharss->map(function($i) {
            return $i->receivedDiscount();
        })->sum();
        

        return view('purchars.index', compact('purchars','purcharss', 'total', 'receivedAmount','receivedDiscount'));
    }

    public function store(PurcharStoreRequest $request)
    {
        $purchar = Purchar::create([
            'supplier_id' => $request->supplier_id,
            'user_id' => $request->user()->id,
        ]);

        $cargo = $request->user()->cargo()->get();
        foreach ($cargo as $item) {
            $purchar->items()->create([
                'cost' => $item->inputprice * $item->pivot->quantity,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id,
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }
        $request->user()->cargo()->detach();
        $purchar->paymentpurs()->create([
            'amount' => $request->amount,
            'discount' => $request->discount,
            'user_id' => $request->user()->id,
        ]);
        return 'success';
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchar  $purchar
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Purchar = Purchar::where("id", $id)->first();
        $purcharitems = PurcharItem::where("purchar_id", $Purchar->id)->get();
        return view('purchars.show', compact('Purchar','purcharitems'));
    }
}
