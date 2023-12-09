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
        $totalpr=$request->totalpr;
        $products = new Product();
        $request->search;
        $products = $products->where('name', 'LIKE', "{$request->search}")
        ->orWhere('barcode', 'LIKE', "{$request->search}")->get();
        $barcode= null;
        return view('print.print',compact('products', 'barcode'));
    }

}