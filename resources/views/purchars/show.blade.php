@extends('layouts.admin')

@section('title', 'Danh sách nhập hàng')
@section('content-header', 'Danh sách nhập hàng')
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-primary"><i class='bx bx-barcode-reader'></i>Nhập hàng</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="layout-demo-info">
            <h1>ĐƠN HÀNG NHẬP</h1>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">
                        <h5>Nhà phân phối: <span class="text-uppercase h5">{{$Purchar->getSupplierName()}}</span></h5>
                    </div>
                    <div class="col d-flex align-items-center justify-content-end">
                        <h6>Ngày nhập: <span class="text-uppercase h5">{{$Purchar->created_at}}</span></h6>
                    </div>
                </div>
                <div class="row  d-flex">
                    <h5>Địa chỉ: <span class="text-uppercase h5">{{$Purchar->getSupplierAddress()}}</span></h5>
                </div>    
                <div class="row  d-flex">
                    <h5>Số điện thoại: <span class="text-uppercase h5">{{$Purchar->getSupplierPhone()}}</span></h5>
                </div>
            </div>
        </div>
        <div class="">
            <table class="table table-striped"  cellpadding="5">
                <thead>
                    <tr class="">
                        <th class="d-flex justify-content-begin">Sản phẩm</th>
                        <th class="">Đơn vị tính</th>
                        <th class="">Số lượng</th>
                        <th>Giá nhập</th>
                        <th class="d-flex justify-content-end">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($purcharitems as $purcharitem)
                    <tr class="" text-align="center">
                        <td class="d-flex justify-content-begin overflow-hidden">{{$purcharitem->product->name}}</td>
                        <td class="">{{$purcharitem->product->description}}</td>
                        <td class="">{{$purcharitem->quantity}}</td>
                        <td class="">{{number_format($purcharitem->cost/$purcharitem->quantity)}}{{ config('settings.currency_symbol') }}</td>
                        <td class="d-flex justify-content-end">{{number_format($purcharitem->cost)}}{{ config('settings.currency_symbol') }}</td>
                    </tr>
                @endforeach    
                </tbody>
            </table>
            <div class="p-2 mt-3">
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Tổng tiền</div>
                    <div class="col d-flex align-items-center justify-content-end">{{$Purchar->formattedTotal()}} {{ config('settings.currency_symbol') }}</div>
                </div>
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Giảm giá</div>
                    <div class="col d-flex align-items-center justify-content-end">{{number_format($Purchar->receivedDiscount())}} {{ config('settings.currency_symbol') }}</div>
                </div>
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Thành tiền</div>
                    <div class="col d-flex align-items-center justify-content-end">{{number_format($Purchar->total()-$Purchar->receivedDiscount())}}{{ config('settings.currency_symbol') }}</div>
                </div>
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Tiền đã thanh toán</div>
                    <div class="col d-flex align-items-center justify-content-end">{{$Purchar->formattedReceivedAmount()}} {{config('settings.currency_symbol') }}</div>
                </div>
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Dư nợ</div>
                    <div class="col d-flex align-items-center justify-content-end">{{number_format($Purchar->total()-$Purchar->receivedDiscount() - $Purchar->receivedAmount())}} {{config('settings.currency_symbol')}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('admin/assets/admin/layout2/js/jQuery.print.js') }}"></script>
                        <script type="text/javascript">
                        function printData()
                        {
                            var divToPrint=document.getElementById("printTable");
                            newWin= window.open("");
                            newWin.document.write(divToPrint.outerHTML);
                            newWin.print();
                            newWin.close();
                        }

                        $('.btnprn').on('click',function(){
                        printData();
                        })
                        </script>
@endsection

