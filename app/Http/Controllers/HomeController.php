<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchar;
use App\Models\Customer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orders = Order::with(['items', 'payments'])->get();
        $purchars = Purchar::with(['items', 'paymentpurs'])->get();
        $customers_count = Customer::count();

        return view('home', [
            'orders_count' => $orders->count(),
            'income' => $orders->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->receivedAmount();
            })->sum(),
            'incomecus' => $orders->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->total()-$i->receivedAmount();
            })->sum(),
            'purchars_count' => $purchars->count(),
            'incomep' => $purchars->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->receivedAmount();
            })->sum(),
            'incomepur' => $purchars->map(function($i) {
                return ($i->total()-$i->receivedAmount());
            })->sum(),
            'income_today' => $orders->where('created_at', '>=', date('Y-m-d').' 00:00:00')->map(function($i) {
                if($i->receivedAmount() > $i->total()) {
                    return $i->total();
                }
                return $i->receivedAmount();
            })->sum(),
            'customers_count' => $customers_count
        ]);
    }
}
