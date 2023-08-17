@extends('layouts.admin')

@section('title', 'Danh sách hóa đơn')
@section('content-header', 'Danh sách hóa đơn')
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-primary">Tạo hóa đơn</a>
    <a href="" class="btn btn-primary">Sửa hóa đơn</a>
    <a href="" class="btn btn-primary m-s">In hóa đơn</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="layout-demo-info">
            <h1>Hóa đơn bán hàng</h1>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div>
                    <h5>Tên khách hàng: <span class="text-uppercase h6">{{$Order->customer->first_name}}</span>
                    </h5>
                    <h5>Địa chỉ: <span class="text-uppercase h6">{{$Order->customer->address}}</span></h2>
                    <h5>Số điện thoại: <span class="text-uppercase h6">{{$Order->customer->phone}}</span></h3>
                </div>
            </div>
            <div class="col-md-4 ">
                    <div class="row">
                        <div class="d-flex justify-content-end">
                            <h5>Ngày mua: <span class="text-uppercase h6">{{$Order->created_at}}</span></h5>
                        </div>
                    </div>
            </div>
        </div>
        <div class="">
            <table class="table table-striped ">
                <thead>
                    <tr class="text-center">
                        <th class="d-flex justify-content-begin">Sản phẩm</th>
                        <th class="">Đơn vị tính</th>
                        <th class="">Số lượng</th>
                        <th>Giá bán</th>
                        <th class="d-flex justify-content-end">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orderitems as $orderItem)
                    <tr class="text-center">
                        <td class="d-flex justify-content-begin overflow-hidden">{{$orderItem->product->name}}</td>
                        <td class="">{{$orderItem->product->description}}</td>
                        <td class="">{{$orderItem->quantity}}</td>
                        <td class="">{{number_format($orderItem->product->price)}}{{ config('settings.currency_symbol') }}</td>
                        <td class="d-flex justify-content-end">{{number_format($orderItem->price)}}{{ config('settings.currency_symbol') }}</td>
                    </tr>
                @endforeach    
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="p-2">
                <div class="row p-2 d-flex mb-1  border-bottom">
                    <div class="col ">Tổng tiền:</div>
                    <div class="col d-flex align-items-center justify-content-end"></div>
                </div>
                <div class="row p-2 d-flex mb-1 border-bottom">
                    <div class="col">Chiết khấu:</div>
                    <div class="col d-flex align-items-center justify-content-end"></div>
                </div>
                <div class="row p-2 d-flex mb-1 border-bottom">
                    <div class="col">Thành tiền:</div>
                    <div class="col d-flex align-items-center justify-content-end">{{$Order->formattedTotal()}} {{ config('settings.currency_symbol') }}</div>
                </div>
                <div class="row p-2 d-flex mb-1 border-bottom">
                    <div class="col">Tiền đã thanh toán:</div>
                    <div class="col d-flex align-items-center justify-content-end">{{$Order->formattedReceivedAmount()}} {{config('settings.currency_symbol') }}</div>
                </div>
                <div class="row p-2 d-flex mb-1 border-bottom">
                    <div class="col">Dư nợ:</div>
                    <div class="col d-flex align-items-center justify-content-end">{{number_format($Order->total() - $Order->receivedAmount())}} {{config('settings.currency_symbol')}}</div>
                </div>
                <div class="row  d-flex mb-1">
                    <div class="col d-flex align-items-center justify-content-end">Người lập hóa đơn</div>
                </div>
                <div class="row p-3 d-flex mb-1 ">
                    <div class="col d-flex align-items-center justify-content-end">
                        <h6>{{ auth()->user()->getFullname() }}</h6>
                    </div>
                </div>
                <div>
                    <a href="" class="btn btn-primary m-s">In hóa đơn</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

