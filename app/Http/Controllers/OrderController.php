<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders = new Order();
        $orderss = new Order();
        $cus = new Customer();
        $cus = $cus->where('last_name', 'LIKE', "%{$request->search}%") ;
        $cuss=$cus->id;
        dd($cuss); 
        
        if ($request->search) {
            $orders = $orders->where('customer_id', 'LIKE', "{$cus}");
            $orderss = $orderss->where('name', 'LIKE', "%{$request->search}%");
        }
        if($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
            $orderss = $orderss->where('created_at', '>=', $request->start_date);
        }
        if($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
            $orderss = $orderss->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
        $orders = $orders->with(['items', 'payments', 'customer'])->latest()->paginate(10);
        $orderss = $orderss->with(['items', 'payments', 'customer'])->latest()->paginate(1000);
        $total = $orderss->map(function($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $orderss->map(function($i) {
            return $i->receivedAmount();
        })->sum();
        $receivedDiscount = $orderss->map(function($i) {
            return $i->receivedDiscount();
        })->sum();
        

        return view('orders.index', compact('orders','orderss', 'total', 'receivedAmount','receivedDiscount'));
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
        ]);

        $cart = $request->user()->cart()->get();
        foreach ($cart as $item) {
            $order->items()->create([
                'price' => $item->outputprice * $item->pivot->quantity,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id,
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }
        $request->user()->cart()->detach();
        $order->payments()->create([
            'amount' => $request->amount,
            'discount' => $request->discount,
            'user_id' => $request->user()->id,
        ]);
        return 'success';
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Order = Order::where("id", $id)->first();
        $orderitems = OrderItem::where("order_id", $Order->id)->get();
        return view('orders.show', compact('Order','orderitems'));
    }
}
