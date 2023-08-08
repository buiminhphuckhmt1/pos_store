@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm')
@section('content-header', 'Danh sách sản phẩm')
@section('content-actions')
<a href="{{route('products.create')}}" class="btn btn-primary">Tạo sản phẩm mới</a>
<a href="{{route('export.export')}}" class="btn btn-primary">Xuất file excel</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="card product-list">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Barcode</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th>Ngày cập nhât</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
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
                    <td>{{$product->price}}</td>
                    <td>{{$product->quantity}}</td>
                    <td>
                    @if ($product->status == 1)
                        <span class="badge bg-label-primary me-1">Hiện</span>
                        @elseif ($product->status  == 0)
                          <span class="badge bg-label-primary me-1">ẨN</span>
                        @else
                          N/A
                        @endif
                    </td>
                    <td>{{$product->updated_at}}</td>
                    <td>
                        <div class="dropdown" style="text-align: center;">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="{{ route('products.edit', $product) }}"><i class="bx bx-edit-alt me-1"></i> Sửa</a>
                              <a class="dropdown-item" href="{{route('products.destroy', $product)}}" onclick="return window.confirm('Bạn có xác nhận xóa không');"><i class="bx bx-trash me-1"></i> Xóa</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->render() }}
    </div>
</div>
@endsection
