<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->wantsJson()) {
            return response(
                Customer::all()
            );
        }
        $customers = Customer::latest()->paginate(10);
        return view('customers.index')->with('customers', $customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {
        $customer = Customer::create([
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'user_id' => $request->user()->id,
        ]);

        if (!$customer) {
            return redirect()->back()->with('Lỗi', 'Xin lỗi đã gặp vấn đề trong lúc tạo khách hàng mới.');
        }
        return redirect()->route('customers.index')->with('Thành công', 'Đã tạo khách hàng mới thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;


        if (!$customer->save()) {
            return redirect()->back()->with('Lỗi', 'Xin lỗi, đã gặp vấn đền trong lúc cập nhật khách hàng.');
        }
        return redirect()->route('customers.index')->with('Thành công', 'Đã cập nhật thông tin khách hàng thành công.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

       return response()->json([
           'success' => true
       ]);
    }
}
