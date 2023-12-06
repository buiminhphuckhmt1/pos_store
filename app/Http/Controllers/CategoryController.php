<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categorys = new Category();
        if ($request->search) {
            $categorys = $categorys->where('name', 'LIKE', "%{$request->search}%");
        }
        $categorys = $categorys->latest()->paginate(1000);
        if (request()->wantsJson()) {
            return CategoryResource::collection($categorys);
        }
        return view('categorys.index')->with('categorys', $categorys);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categorys.create');
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category()
    {
        return view('categorys.category');
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function brand()
    {
        return view('categorys.brand');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('categorys', 'public');
        }
        else{
            $image_path = 'categorys/defaulppicture.jpg';
        }

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image_path,
            'barcode' => $request->barcode,
            'inputprice' => $request->inputprice,
            'outputprice' => $request->outputprice,
            'quantity' => $request->quantity,
            'status' => $request->status
        ]);

        if (!$category) {
            return redirect()->back()->with('lỗi', 'xin lỗi có vấn đề trong khi tạo sản phẩm mới');
        }
        return redirect()->route('categorys.index')->with('thành công', 'sản phẩm đã được tạo.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categorys.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->description = $request->description;
        $category->barcode = $request->barcode;
        $category->inputprice = $request->inputprice;
        $category->outputprice = $request->outputprice;
        $category->quantity = $request->quantity;
        $category->status = $request->status;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                Storage::delete($category->image);
            }
            // Store image
            $image_path = $request->file('image')->store('categorys', 'public');
            // Save to Database
            $category->image = $image_path;
        }

        if (!$category->save()) {
            return redirect()->back()->with('Lỗi', 'xin lỗi có vấn đề khi câp nhât sản phẩm.');
        }
        return redirect()->route('categorys.index')->with('Thành công', 'Cập nhật sản pphẩm thành công.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::delete($category->image);
        }
        $category = Category::delete($category);

        return redirect()->route('categorys.index')->with('Thành công', 'Đã xóa sản phẩm.');
    }
}
