<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Illuminate\Http\Request;

class ExportOrderController extends Controller
{
    public function export()
    {
        return Excel::download(new OrdersExport(), 'products'.'.xlsx');
    }
}