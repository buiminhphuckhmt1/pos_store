<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use Illuminate\Http\Request;

class ExportProductController extends Controller
{
    public function export()
    {
        return Excel::download(new ProductsExport(), 'products'.'.xlsx');
    }
}
