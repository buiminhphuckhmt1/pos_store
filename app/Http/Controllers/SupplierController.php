<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = new Supplier();
        if ($request->search) {
            $suppliers = $suppliers->where('name', 'LIKE', "%{$request->search}%");
        }
        $suppliers = $suppliers->latest()->paginate(10);
        if (request()->wantsJson()) {
            return response(
                Supplier::all()
            );
        }
        return view('suppliers.index')->with('suppliers', $suppliers);
    }

    public function create()
    {

    }

    public function store(SupplierStoreRequest $request)
    {
        $supplier = Supplier::create([
            'phone' => $request->phone,
            'name' => $request->name,
            'country' => $request->country,
            'user_id' => $request->user()->id,
        ]);

        if (!$supplier) {
            return redirect()->back()->with('error', 'xin lỗi có vấn đề trong khi thêm nhà cung cấp');
        }
        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Danh mục sản phẩm đã được tạo.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->loadMissing('purchases')->get();

        return view('suppliers.show', [
            'supplier' => $supplier
        ]);
    }

    public function edit(Supplier $supplier)
    {
  
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Supplier  $category
    * @return \Illuminate\Http\Response
    */

    public function update(SupplierUpdateRequest $request, Supplier $supplier)
    {
        //

        /**
         * Handle upload image with Storage.
         */
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->country = $request->country;
       // dd($supplier->phone,$supplier->name,$supplier->country);

        if (!$supplier->save()) {
            return redirect()->back()->with('error', 'xin lỗi có vấn đề trong khi cập nhật nhà cung cấp');
        }
        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Thông tin nhà cung cấp đã được cập nhật');
    }

    public function destroy(Supplier $supplier)
    {
        /**
         * Delete photo if exists.
         */
        if($supplier->photo){
            unlink(public_path('storage/suppliers/') . $supplier->photo);
        }

        $supplier->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier has been deleted!');
    }
}
