@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm')
@section('content-header', 'Danh sách sản phẩm')
@section('search')
        <form class="d-flex" action="{{ route('products.index') }}" method="GET" enctype="multipart/form-data">
@endsection
@section('content-actions')
<a href="{{route('products.create')}}" class="btn btn-primary"><i class='bx bx-add-to-queue' ></i> Tạo sản phẩm mới</a>
<a href="{{route('categorys.index')}}" class="btn btn-primary"></i> Danh mục</a>
<a href="{{route('brands.index')}}" class="btn btn-primary"></i> Thương hiệu</a>
<a href="{{route('print.print')}}" class="btn btn-primary"></i> In Nhãn</a>
<a href="{{route('export.export')}}" class="btn btn-primary"><i class='bx bxs-download'></i> Xuất file excel</a>
<a href="" class="btn btn-primary"><i class='bx bx-up-arrow-alt' ></i> Nhập file excel</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
@endsection
@section('content')
<div class="card product-list">
    <div class="card-body">
      <div class="table-responsive text-nowrap">
      <table class="table">
            <thead>
                <tr>
                    <th>Thao tác</th>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Barcode</th>
                    <th>Thương hiệu</th>
                    <th>Danh mục</th>
                    <th>Đơn vị bán</th>
                    <th>Đơn vị nhập</th>
                    <th>Giá bán</th>
                    <th>Giá nhập</th>
                    <th>Số lượng</th>
                    <th>Cảnh báo</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th>
                    <th>Ngày cập nhât</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr style="text-align: center;">
                  <td>
                    <div class="dropdown" style="text-align: center;">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item btn-edit" data-url="{{ route('products.edit', $product) }}"><i class="bx bx-edit-alt me-1"></i> Sửa</a>
                          <button class="dropdown-item btn-delete" data-url="{{route('products.destroy', $product)}}"><i class="bx bx-trash me-1"></i> Xóa</button>
                        </div>
                      </div>
                    </td>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>
                        <ul class="users-list m-0 avatar-group d-flex align-items-center p-0" style="list-style: none;">
                          <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" title="" data-bs-original-title="{{$product->name}}">
                            <img src="{{ Storage::url($product->image) }}" alt="Avatar" class="">                           
                          </li>
                        </ul>                        
                    </td>                    
                    <td>{{$product->barcode}}</td>
                    <td>{{$product->category->name}}</td>
                    <td>{{$product->brand->name}}</td>
                    <td>{{$product->unit_purchas}}</td>
                    <td>{{$product->unit_sale}}</td>
                    <td>{{ number_format($product->inputprice) }} {{ config('settings.currency_symbol') }}</td>
                    <td>{{ number_format($product->outputprice) }} {{ config('settings.currency_symbol') }}</td>
                    <td></td>
                    <td>{{$product->stock_alert}}</td>
                    <td>
                    @if ($product->status == 1)
                        <span class="badge bg-label-primary me-1">Hiện</span>
                        @elseif ($product->status  == 0)
                          <span class="badge bg-label-primary me-1">ẨN</span>
                        @else
                          N/A
                        @endif
                    </td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->updated_at}}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <div class="mt-3">{{ $products->render() }}</div>
    </div>
</div>
@endsection
