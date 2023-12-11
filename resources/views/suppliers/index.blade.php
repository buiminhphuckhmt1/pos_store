@extends('layouts.admin')

@section('title', 'Nhà cung cấp')
@section('content-header', 'Nhà cung cấp')
@section('search')
        <form class="d-flex" action="{{ route('suppliers.index') }}" method="GET" enctype="multipart/form-data">
@endsection
@section('content-actions')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#SupplierModal">
    Thêm nhà cung cấp
</button>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
@endsection
@section('content')
<form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                        <div class="modal fade" id="SupplierModal" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Tạo danh mục</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="">
                                <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Tên nhà cung cấp</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên nhà cung cấp">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>

                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" id="phone" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập số điện thoại">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>

                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Địa chỉ</label>
                                        <input type="text" name="country" id="country" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập địa chỉ">
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                    
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Đóng
                                </button>
                                <button type="submit" class="btn btn-primary">Lưu</button>
                              </div>
                            </div>
                          </div>
                        </div>
</form>

<div class="card product-list">
    <div class="card-body">
      <div class="table-responsive text-nowrap ">
      <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="min-width: 100px;">Tên nhà cung cấp</th>
                    <th>Người thêm</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ nhà cung cấp</th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($suppliers as $supplier)
                <tr>
                    <td>{{$supplier->id}}</td>
                    
                    <td>{{$supplier->name}}</td>
                    <td>{{$supplier->user->last_name}}</td>
                    <td>{{$supplier->phone}}</td>
                    <td>{{$supplier->country}}</td>
                    <td style="text-align: right;">
                        <div class="dropdown" style="text-align: right; padding-right: 20px;">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <button class="dropdown-item btn" data-bs-toggle="modal" data-bs-target="#SuppliereditModal{{$supplier->id}}"><i class="bx bx-edit-alt me-1"></i>Sửa</button>
                              <button class="dropdown-item btn-delete" data-url="{{route('suppliers.destroy', $supplier)}}"><i class="bx bx-trash me-1"></i> Xóa</button>
                            </div>
                        </div>
                    </td>
                </tr>
                <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                        <div class="modal fade" id="SuppliereditModal{{$supplier->id}}" tabindex="-1" aria-hidden="true" style="display: none;">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Sửa danh mục</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="">
                                    
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Tên nhà cung cấp</label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên nhà cung cấp"
                                        value="{{ old('name', $supplier->name) }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Số điện thoại</label>
                                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Nhập số điện thoại"
                                        value="{{ old('phone', $supplier->phone) }}">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                    <div class="col mb-3">
                                        <label for="nameBasic" class="form-label">Địa chỉ</label>
                                        <input type="text" name="country" id="country" class="form-control @error('country') is-invalid @enderror" placeholder="Nhập địa chỉ"
                                        value="{{ old('country', $supplier->country) }}">
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                  Đóng
                                </button>
                                <button type="submit" class="btn btn-primary">Lưu</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </form>
                @endforeach
            </tbody>
        </table>
        {{ $suppliers->render() }}
      </div>
    </div>
</div>
@endsection
