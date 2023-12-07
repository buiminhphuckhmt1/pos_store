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
    //
     /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index(Request $request)
    {
        $categorys = new Category();
        if ($request->search) {
            $categorys = $categorys->where('name', 'LIKE', "%{$request->search}%");
        }
        $categorys = $categorys->latest()->paginate(10);
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
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        if (!$category) {
            return redirect()->back()->with('error', 'xin lỗi có vấn đề trong khi tạo danh mục sản phẩm mới');
        }
        return redirect()->route('categorys.index')->with('success', 'Danh mục sản phẩm đã được tạo.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

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
        $category->code = $request->code;

        if ($category->save()) {
            return redirect()->route('categorys.index')->with('success', 'Cập nhật danh mục thành công.');
        }
            return redirect()->route('categorys.index')->with('error', 'xin lỗi có vấn đề khi cập nhật danh mục.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category = Category::delete($category);
        return redirect()->route('categorys.index')->with('success', 'Đã xóa sản phẩm.');
    }
}

