<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $qty = new ProductVariant();
        $categorys = new Category();
        $categorys = $categorys->latest()->paginate(100);
        $brands = new Brand();
        $brands = $brands->latest()->paginate(100);
        $products = new Product();
        
        if ($request->search) {
            $products = $products->where('name', 'LIKE', "%{$request->search}%")->orWhere('barcode', 'LIKE', "{$request->search}");
        }
        elseif ($request->barcode && $request->name && $request->category_id && $request->brand_id) {
            $products = $products->where('barcode', 'LIKE', "%{$request->barcode}%")->where('name', 'LIKE', "%{$request->name}%")->where('category_id', 'LIKE', "{$request->category_id}")->where('brand_id', 'LIKE', "{$request->brand_id}");
        }
        elseif ($request->barcode && $request->name && $request->category_id) {
            $products = $products->where('barcode', 'LIKE', "%{$request->barcode}%")->where('name', 'LIKE', "%{$request->name}%")->where('category_id', 'LIKE', "{$request->category_id}");
        }
        elseif ($request->barcode && $request->name &&  $request->brand_id) {
            $products = $products->where('barcode', 'LIKE', "%{$request->barcode}%")->where('name', 'LIKE', "%{$request->name}%")->where('brand_id', 'LIKE', "{$request->brand_id}");
        }
        elseif ($request->barcode  && $request->category_id && $request->brand_id) {
            $products = $products->where('barcode', 'LIKE', "%{$request->barcode}%")->where('category_id', 'LIKE', "{$request->category_id}")->where('brand_id', 'LIKE', "{$request->brand_id}");
        }
        elseif ($request->barcode && $request->name) {
            $products = $products->where('barcode', 'LIKE', "%{$request->barcode}%")->where('name', 'LIKE', "%{$request->name}%");
        }
        elseif ($request->barcode && $request->category_id) {
            $products = $products->where('barcode', 'LIKE', "%{$request->barcode}%")->where('category_id', 'LIKE', "{$request->category_id}");
        }
        elseif ($request->barcode && $request->brand_id) {
            $products = $products->where('barcode', 'LIKE', "%{$request->barcode}%")->where('brand_id', 'LIKE', "{$request->brand_id}");
        }
        elseif ($request->barcode) {
            $products = $products->where('barcode', 'LIKE', "{$request->barcode}%");
        }
        elseif ($request->name) {
            $products = $products->where('name', 'LIKE', "%{$request->name}%");
        }
        elseif ($request->name && $request->category_id) {
            $products = $products->where('name', 'LIKE', "%{$request->name}%")->where('category_id', 'LIKE', "{$request->category_id}");
        }
        elseif ($request->name && $request->category_id && $request->brand_id) {
            $products = $products->where('name', 'LIKE', "%{$request->name}%")->where('category_id', 'LIKE', "{$request->category_id}")->where('brand_id', 'LIKE', "{$request->brand_id}");
        }
        elseif ($request->category_id) {
            $products = $products->where('category_id', 'LIKE', "{$request->category_id}");
        }
        elseif ( $request->category_id && $request->brand_id) {
            $products = $products->where('category_id', 'LIKE', "{$request->category_id}")->where('brand_id', 'LIKE', "{$request->brand_id}");
        }
        elseif ($request->brand_id) {
            $products = $products->where('brand_id', 'LIKE', "{$request->brand_id}");
        }
        $products = $products->latest()->paginate(10);
        if (request()->wantsJson()) {
            return ProductResource::collection($products);
        }
        return view('products.index',compact('products', 'brands','categorys','qty'));
    }


   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = new Category();
        $products = $products->latest()->paginate(100);
        $brands = new Brand();
        $brands = $brands->latest()->paginate(100);
        return view('products.create',compact('products', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products', 'public');
        }
        else{
            $image_path = 'products/defaulppicture.jpg';
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image_path,
            'barcode' => $request->barcode,
            'category_id' =>$request->category_id,
            'brand_id'=>$request->brand_id,
            'unit_sale'=>$request->unit_sale,
            'unit_purchas'=>$request->unit_purchas,
            'inputprice' => $request->inputprice,
            'outputprice' => $request->outputprice,
            'discountpercen'=>$request->discountpercen,
            'stock_alert' => $request->stock_alert,
            'status' => $request->status
        ]);

        if (!$product) {
            return redirect()->back()->with('error', 'xin lỗi có vấn đề trong khi tạo sản phẩm mới');
        }
        return redirect()->route('products.index')->with('success', 'sản phẩm đã được tạo.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categorys = new Category();
        $categorys = $categorys->latest()->paginate(100);
        $brands = new Brand();
        $brands = $brands->latest()->paginate(100);
        return view('products.edit',compact('brands','categorys'))->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        $product->barcode = $request->barcode;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->unit_sale = $request->unit_sale;
        $product->unit_purchas = $request->unit_purchas;
        $product->inputprice = $request->inputprice;
        $product->outputprice = $request->outputprice;
        $product->stock_alert = $request->stock_alert;
        $product->status = $request->status;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::delete($product->image);
            }
            // Store image
            $image_path = $request->file('image')->store('products', 'public');
            // Save to Database
            $product->image = $image_path;
        }

        if (!$product->save()) {
            return redirect()->back()->with('error', 'xin lỗi có vấn đề khi câp nhât sản phẩm.');
        }
        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product = Product::delete($product);

        return redirect()->route('products.index')->with('success', 'Đã xóa sản phẩm.');
    }
}
