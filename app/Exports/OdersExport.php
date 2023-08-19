<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::all();
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->customer_id,
            $row->image,
            $row->barcode,
            $row->inputprice,
            $row->outputprice,
            $row->quantity,
            $row->status,
            $row->updated_at,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:B1:C1:D1:E1:F1:G1:H1';
                $color = '93ccea';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB($color);
            }
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'tên sản phẩm',
            'ảnh',
            'mã vạch',
            'giá',
            'số lượng',
            'trạng thái',
            'ngày cập nhật'
        ];
    }
    
    public function columnWidths(): array
    {
        return [
            'id' => 10,
            'tên sản phẩm' => 30,
            'ảnh' => 30,
            'mã vạch' => 30,
            'giá' => 30,
            'số lượng' => 30,
            'trạng thái' => 20,
            'ngày cập nhật' => 30,
        ];
    }
}
