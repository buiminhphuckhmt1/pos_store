@extends('layouts.admin')

@section('title', 'Danh sách hóa đơn')
@section('content-header', 'Danh sách hóa đơn')
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-primary">Tạo hóa đơn</a>
    <a href="" class="btn btn-primary">Sửa hóa đơn</a>
    <a href="javascrip:;" class="btnprn btn btn-primary m-s">In hóa đơn</a>
@endsection

@section('content')
<div id="printTable">
<div class="card">
    <div class="card-body">
        <div class="layout-demo-info">
            <h1>Hóa đơn bán hàng</h1>
        </div>
        <div class="row">
            <div class="col-md-8">
                    <table class="table table-striped " width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                        <tbody>
                            <tr>
                                <td><h4>Tên khách hàng: <span class="text-uppercase h5">{{$Order->getCustomerName()}}</span></h4></td>
                                <td class="d-flex justify-content-end"> <h4>Ngày mua: <span class="text-uppercase h5">{{$Order->created_at}}</span></h4></td>
                            </tr>
                            <tr>
                                <td><h4>Địa chỉ: <span class="text-uppercase h5">{{$Order->getCustomerAddress()}}</span></h4></td>
                            </tr>
                            <tr>
                                <td><h4>Số điện thoại: <span class="text-uppercase h5">{{$Order->getCustomerPhone()}}</span></h4></td>
                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>
        <div class="">
            <table class="table table-striped" width="100%"  cellpadding="5">
                <thead>
                    <tr class="">
                        <th class="d-flex justify-content-begin">Sản phẩm</th>
                        <th class="">Đơn vị tính</th>
                        <th class="">Số lượng</th>
                        <th>Giá bán</th>
                        <th class="d-flex justify-content-end">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orderitems as $orderItem)
                    <tr class="" text-align="center">
                        <td class="d-flex justify-content-begin overflow-hidden">{{$orderItem->product->name}}</td>
                        <td class="">{{$orderItem->product->description}}</td>
                        <td class="">{{$orderItem->quantity}}</td>
                        <td class="">{{number_format($orderItem->price/$orderItem->quantity)}}{{ config('settings.currency_symbol') }}</td>
                        <td class="d-flex justify-content-end">{{number_format($orderItem->price)}}{{ config('settings.currency_symbol') }}</td>
                    </tr>
                @endforeach    
                </tbody>
            </table>
            <table class="table table-striped " width="100%" >
                <thead>
                    <tr class=>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="">
                        <td class="">Tổng tiền:</td>
                        <td class="d-flex justify-content-end">0</td>
                    </tr>
                    <tr class="">
                        <td class="">Chiết khấu:</td>
                        <td class="d-flex justify-content-end">0</td>
                    </tr>
                    <tr class="">
                        <td class="">Thành tiền:</td>
                        <td class="d-flex justify-content-end">{{$Order->formattedTotal()}} {{ config('settings.currency_symbol') }}</td>
                    </tr>
                    <tr class="">
                        <td class="">Tiền đã thanh toán:</td>
                        <td class="d-flex justify-content-end">{{$Order->formattedReceivedAmount()}} {{config('settings.currency_symbol') }}</td>
                    </tr>
                    <tr class="">
                        <td class="">Dư nợ:</td>
                        <td class="d-flex justify-content-end">{{number_format($Order->total() - $Order->receivedAmount())}} {{config('settings.currency_symbol')}}</td>
                </tbody>
            </table>
            <div class="p-2">
                <div class="row  d-flex mb-1">
                    <div class="p-3 col d-flex align-items-center justify-content-begin">Khách hàng</div>
                    <div class="col d-flex align-items-center justify-content-end">Người lập hóa đơn</div>
                </div>
                <div class="row p-3 d-flex mb-1 ">
                    <div class="col p-0 d-flex align-items-center justify-content-begin">
                        <h6>{{ $Order->getCustomerName() }}</h6>
                    </div>
                    <div class="col d-flex align-items-center justify-content-end">
                        <h6>{{ auth()->user()->getFullname() }}</h6>
                    </div>
                </div>
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

