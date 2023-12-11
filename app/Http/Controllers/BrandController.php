<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index(Request $request)
    {
        $brands = new Brand();
        if ($request->search) {
            $brands = $brands->where('name', 'LIKE', "%{$request->search}%");
        }
        $brands = $brands->latest()->paginate(10);
        if (request()->wantsJson()) {
            return BrandResource::collection($brands);
        }
        return view('brands.index')->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandStoreRequest $request)
    {
        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('brands', 'public');
        }
        else{
            $image_path = 'products/defaulppicture.jpg';
        }
        $brand = Brand::create([
            'image' => $image_path,
            'name' => $request->name,
        ]);

        if (!$brand) {
            return redirect()->back()->with('error', 'xin lỗi có vấn đề trong khi tạo thương hiệu sản phẩm mới');
        }
        return redirect()->route('brands.index')->with('success', 'Thương hiệu sản phẩm đã được tạo.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        $brand->name = $request->name;
        if ($request->hasFile('image')) {
            // Delete old image
            if ($brand->image) {
                Storage::delete($brand->image);
            }
            // Store image
            $image_path = $request->file('image')->store('brands', 'public');
            // Save to Database
            $brand->image = $image_path;
        }

        if ($brand->save()) {
            return redirect()->route('brands.index')->with('success', 'Cập nhật thương hiệu thành công.');
        }
            return redirect()->route('brands.index')->with('error', 'xin lỗi có vấn đề khi cập nhật thương hiệu.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        
        $brand->delete();

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Đã xóa thương hiệu');
    }
}

