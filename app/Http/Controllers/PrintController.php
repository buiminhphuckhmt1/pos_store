<?php

namespace App\Http\Controllers;


use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        $products = new Product();
        $request->search;
        $products = $products->where('name', 'LIKE', "{$request->search}")
        ->orWhere('barcode', 'LIKE', "{$request->search}")->get();

        return view('print.print')->with('products', $products);
    }

}