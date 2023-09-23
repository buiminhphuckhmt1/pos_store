@extends('layouts.admin')

@section('title', 'Danh sách hóa đơn')
@section('content-header', 'Danh sách hóa đơn')
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-primary"><i class='bx bx-barcode-reader'></i> Tạo hóa đơn</a>
    <a href="javascrip:;" class="btnprn btn btn-primary m-s"><i class='bx bx-printer'></i> In hóa đơn</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="layout-demo-info">
            <h1>Hóa đơn bán hàng</h1>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">
                        <h5>Tên khách hàng: <span class="text-uppercase h5">{{$Order->getCustomerName()}}</span></h5>
                    </div>
                    <div class="col d-flex align-items-center justify-content-end">
                        <h6>Ngày mua: <span class="text-uppercase h5">{{$Order->created_at}}</span></h6>
                    </div>
                </div>
                <div class="row  d-flex">
                    <h5>Địa chỉ: <span class="text-uppercase h5">{{$Order->getCustomerAddress()}}</span></h5>
                </div>    
                <div class="row  d-flex">
                    <h5>Số điện thoại: <span class="text-uppercase h5">{{$Order->getCustomerPhone()}}</span></h5>
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
            <div class="p-2 mt-3">
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Tổng tiền</div>
                    <div class="col d-flex align-items-center justify-content-end">{{$Order->formattedTotal()}} {{ config('settings.currency_symbol') }}</div>
                </div>
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Giảm giá</div>
                    <div class="col d-flex align-items-center justify-content-end">{{number_format($Order->receivedDiscount())}} {{ config('settings.currency_symbol') }}</div>
                </div>
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Thành tiền</div>
                    <div class="col d-flex align-items-center justify-content-end">{{number_format($Order->total()-$Order->receivedDiscount())}}{{ config('settings.currency_symbol') }}</div>
                </div>
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Tiền đã thanh toán</div>
                    <div class="col d-flex align-items-center justify-content-end">{{$Order->formattedReceivedAmount()}} {{config('settings.currency_symbol') }}</div>
                </div>
                <div class="row  d-flex">
                    <div class="p-2 col d-flex align-items-center justify-content-begin">Dư nợ</div>
                    <div class="col d-flex align-items-center justify-content-end">{{number_format($Order->total()-$Order->receivedDiscount() - $Order->receivedAmount())}} {{config('settings.currency_symbol')}}</div>
                </div>
            </div>
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
<div id="printTable" class="d-none">
    <div class="card">
        <div class="card-body">
            <div class="layout-demo-info">
                <table class="table table-striped "  width="100%">
                    <tbody>
                    <thead>
                            <th width="80%"></th>
                            <th width="20%"></th>
                        </thead>
                        <tr>
                            <td><h1> Cửa hàng Thân Nguyệt</h1></td>
                        </tr>
                        <tr>
                            <td><h2>ĐC:Ql48B, Quỳnh Châu, Quỳnh Lưu, NA </h2></td>
                            <td><h1>HÓA ĐƠN BÁN HÀNG</h1></td>
                        </tr>
                        <tr>
                            <td><h2>SĐT:0329790031-09664726629-0988690507</h2></td>
                        </tr>
                    </tbody>
                </table>
                <div width="100%">
                _________________________________________________________________________________________________________________________________
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-striped "  width="100%">
                        <thead>
                            <th width="70%"></th>
                            <th width="30%"></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td><h1>{{$Order->getCustomerName()}}</h1></td>
                                <td class="d-flex justify-content-end"> <h2>No:/{{$Order->id}}</h2></td>
                            </tr>
                            <tr>
                                <td><h2>ĐC:{{$Order->getCustomerAddress()}}</h2></td>
                            </tr>
                            <tr>
                                <td><h2>SĐT:{{$Order->getCustomerPhone()}}</h2></td>
                                <td class="d-flex justify-content-end"> <h2>{{$Order->created_at}}</h2></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="">
                <table class="table table-striped" width="100%"  cellpadding="5">
                    <thead>
                        <tr class="">
                            <td width="39%"><h2>Sản phẩm</h2></td>
                            <th width="10%"><h2>Đơn vị</h2></th>
                            <th width="13%"><h2>Số lượng</h2></th>
                            <th width="23%"><h2>Giá bán</h2></th>
                            <td><h2>Thành tiền</h2></td>
                        </tr>
                        <div width="100%">
                _________________________________________________________________________________________________________________________________
                </div>
                    </thead>
                    <tbody>
                    @foreach($orderitems as $orderItem)
                        <tr class="" text-align="center">
                            <td class="d-flex justify-content-begin overflow-hidden"><h2>{{$orderItem->product->name}}</h2></td>
                            <th class=""><h2>{{$orderItem->product->description}}</h2></th>
                            <th class=""><h2>{{$orderItem->quantity}}</h2></th>
                            <th class=""><h2>{{number_format($orderItem->price/$orderItem->quantity)}}{{ config('settings.currency_symbol') }}</h2></th>
                            <td class="d-flex justify-content-end"><h2>{{number_format($orderItem->price)}}{{ config('settings.currency_symbol') }}</h2></td>
                        </tr>
                    @endforeach    
                    </tbody>
                </table>
                <div width="100%">_________________________________________________________________________________________________________________________________</div>
                <table class="table table-striped "  width="100%" >
                    <thead>
                        <tr class=>
                            <th width="70%"></th>
                            <th width="15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td class=""></td>
                            <td class=""><h2>Tổng tiền:</h2></td>
                            <td class="d-flex justify-content-end"><h2>{{$Order->formattedTotal()}} {{ config('settings.currency_symbol') }}</h2></td>
                        </tr>
                        <tr class="">
                            <td class=""></td>
                            <td class=""><h2>Chiết khấu:</h2></td>
                            <td class="d-flex justify-content-end"><h2>{{number_format($Order->receivedDiscount())}} {{ config('settings.currency_symbol') }}</h2></td>
                        </tr>
                      
                        <tr class="">
                            <td class=""></td>
                            <td class=""><h2>Thành tiền:</h2></h2></td>
                            <td class="d-flex justify-content-end"><h2>{{number_format($Order->total()-$Order->receivedDiscount())}}{{ config('settings.currency_symbol') }}</h2></td>
                        </tr>
                        <tr class="">
                            <td class=""></td>
                            <td class=""><h2>Đã trả:</h2></td>
                            <td class="d-flex justify-content-end"><h2>{{$Order->formattedReceivedAmount()}} {{config('settings.currency_symbol') }}</h2></td>
                        </tr>
                        <tr class="">
                            <td class=""></td>
                            <td class=""><h2>Dư nợ:</h2></td>
                            <td class="d-flex justify-content-end"><h2>{{number_format($Order->total()-$Order->receivedDiscount() - $Order->receivedAmount())}} {{config('settings.currency_symbol')}}</h2></td>
                        </tr>
                        </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <th width="25%"><h2>Khách hàng</h2></th>
                            <th width="52%"></th>
                            <th><h2>Người lập hóa đơn</h2></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <th>.</th>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <th>.</th>
                            <td></td>
                        </tr>
                        <tr>
                        <th><h3>{{ $Order->getCustomerName() }}</h3></th>
                        <td></td>
                        <th><h3>{{ auth()->user()->getFullname() }}</h3></th>
                        </tr>
                    </tbody>
                </table>
                <div width="100%">_________________________________________________________________________________________________________________________________</div>
                <table>
                    <thead>
                        <tr>
                            <th width="100%"><h2>Cảm ơn quý khách hàng đã mua hàng.</h2></th>
                        </tr>
                        <tr>
                            <th width="100%"><h2>Lưu ý: Chỉ được đổi tra khi hàng hóa còn nguyên vẹn và có hóa đơn! Xin cảm ơn.</h2></th>
                        </tr>
                    </thead>
                </table>
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

